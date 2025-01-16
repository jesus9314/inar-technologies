<?php

namespace App\Traits\Forms;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Models\DocumentType;
use App\Models\IssuePriority;
use App\Models\Maintenance;
use App\Traits\Forms\UserForms;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Torgodly\Html2Media\Actions\Html2MediaAction;

trait MaintenanceTraitForms
{
    use CommonForms;

    private static function maintenance_form(Form $form): Form
    {
        return $form->schema(self::maintenance_schema());
    }

    private static function maintenance_schema(): array
    {
        return [
            Wizard::make([
                Step::make('General')
                    ->icon('heroicon-c-calendar')
                    ->schema([
                        TextInput::make('code')
                            ->label('Código')
                            ->disabled(true)
                            ->default(fn() => str_pad(Maintenance::count() + 1, 4, '0', STR_PAD_LEFT))
                            ->required(),
                        DatePicker::make('start_date')
                            ->label('Fecha de inicio')
                            ->default(now())
                            ->native(false)
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('Fecha de finalización')
                            ->default(now()->addDays(2))
                            ->native(false),
                        Select::make('maintenance_state_id')
                            ->relationship(
                                name: 'maintenanceState',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn(Builder $query) => $query->where('type', 'maintenance')
                            )
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->default(2)
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->label('Cliente')
                            ->createOptionForm(fn() => self::customer_schema())
                            ->editOptionForm(fn() => self::customer_schema())
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('device_id')
                            ->relationship(
                                name: 'device',
                                titleAttribute: 'name',
                            )
                            ->searchable()
                            ->createOptionForm(self::device_schema())
                            ->editOptionForm(self::device_schema())
                            ->preload()
                            ->required(),
                        Select::make('user_id')
                            ->label('Técnico asignado')
                            ->relationship(
                                name: 'user',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn(Builder $query) => $query->whereNot('id', 1)->where('customer_id', null)
                            )
                            ->createOptionForm(self::user_form())
                            ->editOptionForm(self::user_form())
                            ->searchable()
                            ->preload()
                            ->required(),
                        RichEditor::make('customer_request')
                            ->required()
                            ->columnSpanFull()
                    ])
                    ->columns(2),
                Step::make('Información')
                    ->icon('heroicon-m-document-chart-bar')
                    ->schema([
                        RichEditor::make('description')
                            ->required()
                            ->columnSpanFull(),
                        Repeater::make('maintenanceIssues')
                            ->label('Problemas y posibles soluciones')
                            ->relationship('maintenanceIssues')
                            ->defaultItems(1)
                            ->collapsible()
                            ->collapsed()
                            ->cloneable()
                            ->itemLabel(fn(array $state): ?string => $state['issues'] ?? null)
                            ->schema([
                                RichEditor::make('issues')
                                    ->required(),
                                RichEditor::make('solution')
                                    ->required(),
                                Select::make('issue_priority_id')
                                    ->label('Prioridad')
                                    ->relationship('issuePriority', 'name') // Relación en el modelo MaintenanceIssue
                                    ->searchable()
                                    ->preload()
                                    ->default(2)
                                    ->required(),
                            ])->columnSpan('full')
                    ]),
                Step::make('Procedimientos')
                    ->icon('heroicon-m-document-check')
                    ->schema([
                        TableRepeater::make('maintenanceProcedures')
                            ->headers([
                                Header::make('Procedimiento'),
                                Header::make('Estado'),
                            ])
                            ->label('Procedimientos de mantenimiento')
                            ->relationship('maintenanceProcedures')
                            ->defaultItems(5)
                            ->collapsible()
                            ->collapsed()
                            ->cloneable()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->live(onBlur: true),
                                Checkbox::make('status')
                                    ->default(false)
                            ])
                            ->columnSpanFull(),
                        RichEditor::make('recommendations')
                            ->label('Recomendaciones al cliente')
                            ->required()
                    ]),
                Step::make('Conclusiones')
                    ->icon('heroicon-s-cube')
                    ->schema([
                        RichEditor::make('solution')
                            ->label('Solución')
                            ->required(),

                    ]),
                Step::make('Documentos')
                    ->icon('heroicon-c-folder-open')
                    ->schema([
                        TableRepeater::make('documents')
                            ->headers([
                                Header::make('Código')
                                    ->width('15%'),
                                Header::make('Tipo de documento')
                                    ->width('25%'),
                                Header::make('Ubicación')
                                    ->width('25%'),
                                Header::make('Documento')
                                    ->width('30%'),
                            ])
                            ->relationship('documents')
                            ->defaultItems(2)
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                TextInput::make('code')
                                    ->label('Código')
                                    ->disabled(true)
                                    ->live(onBlur: true)
                                    // ->default(fn(Get $get, $state) => $state = strval($get('../../code')))
                                    ->required(),
                                Select::make('document_type_id')
                                    ->relationship('documentType', 'name')
                                    ->searchable()
                                    ->native(false)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn($state, Get $get, Set $set) => self::get_document_type_sufix($state, $get, $set))
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->preload()
                                    ->required(),
                                Select::make('warehouse_id')
                                    ->relationship('warehouse', 'description')
                                    ->createOptionForm(self::warehouse_schema())
                                    ->editOptionForm(self::warehouse_schema())
                                    ->label('Ubicación')
                                    ->preload()
                                    ->searchable()
                                    ->native(false)
                                    ->required(),
                                FileUpload::make('document_url')
                                    ->label('Documento')
                                    ->downloadable()
                                    ->acceptedFileTypes(['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                                    ->required(),
                            ])
                            ->default(
                                function (Get $get) {
                                    $sufix1 = strval(DocumentType::find(1)->sufijo);
                                    $man_code1 = strval($get('code') . $sufix1);

                                    $sufix2 = strval(DocumentType::find(3)->sufijo);
                                    $man_code2 = strval($get('code') . $sufix2);
                                    return [
                                        [
                                            'code' => $man_code1,
                                            'document_type_id' => '1',
                                        ],
                                        [
                                            'code' => $man_code2,
                                            'document_type_id' => '3',
                                        ]
                                    ];
                                }
                            )
                    ])
            ])
                ->columnSpanFull()
                ->skippable(),
        ];
    }

    protected static function get_document_type_sufix($state, Get $get, Set $set): void
    {
        $sufix = strval(DocumentType::find($state)->sufijo);
        $code = strval($get('../../code'));
        $document_code = "";
        $get('document_type_id') ? $document_code = $code . $sufix : $document_code = $code;
        $set('code',  $document_code);
    }
}
