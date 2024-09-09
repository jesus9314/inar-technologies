<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\InvoiceResource\Pages\CreateInvoice;
use App\Filament\Resources\InvoiceResource\Pages\EditInvoice;
use App\Filament\Resources\InvoiceResource\Pages\ListInvoices;
use App\Filament\Resources\InvoiceResource\Pages\ViewInvoice;
use App\Models\Account;
use App\Models\Action;
use App\Models\Company;
use App\Models\Customer;
use App\Traits\Forms\ProductTraitForms;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;
use TomatoPHP\FilamentLocations\Models\Currency;
use TomatoPHP\FilamentInvoices\Facades\FilamentInvoices;
use TomatoPHP\FilamentTypes\Models\Type;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource as BaseInvoiceResource;
use TomatoPHP\FilamentInvoices\Models\Invoice;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Filament\Actions;

class InvoiceResource extends BaseInvoiceResource
{
    use ProductTraitForms;

    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-c-truck';

    public static function form(Form $form): Form
    {
        $types = Type::query()
            ->where('for', 'invoices')
            ->where('type', 'type');

        $statues = Type::query()
            ->where('for', 'invoices')
            ->where('type', 'status');

        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Tipos')
                        ->schema([
                            Forms\Components\TextInput::make('uuid')
                                ->unique(ignoreRecord: true)
                                ->disabled(fn(Invoice $invoice) => $invoice->exists)
                                ->label(trans('filament-invoices::messages.invoices.columns.uuid'))
                                ->default(fn() => 'INV-' . \Illuminate\Support\Str::uuid())
                                ->required()
                                ->columnSpanFull()
                                ->maxLength(255),

                            Forms\Components\Grid::make([
                                'sm' => 1,
                                'lg' => 12,
                            ])->schema([
                                Forms\Components\Section::make(trans('filament-invoices::messages.invoices.sections.from_type.title'))
                                    ->schema([
                                        Forms\Components\Hidden::make('from_type')
                                            ->label(trans('filament-invoices::messages.invoices.sections.from_type.columns.from_type'))
                                            ->default(Company::class)
                                            ->live()
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('from_id')
                                            ->label(trans('filament-invoices::messages.invoices.sections.from_type.columns.from'))
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->native(false)
                                            ->disabled(fn(Forms\Get $get) => !$get('from_type'))
                                            ->options(fn(Forms\Get $get) => $get('from_type') ? $get('from_type')::query()->pluck(FilamentInvoices::getFrom()->where('model', $get('from_type'))->first()?->column ?? 'name', 'id')->toArray() : [])
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->columnSpan(6)
                                    ->collapsible()
                                    ->collapsed(fn($record) => $record),
                                Forms\Components\Section::make(trans('filament-invoices::messages.invoices.sections.billed_from.title'))
                                    ->schema([
                                        Forms\Components\Hidden::make('for_type')
                                            ->label(trans('filament-invoices::messages.invoices.sections.billed_from.columns.for_type'))
                                            ->default(Customer::class)
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('for_id')
                                            ->label(trans('filament-invoices::messages.invoices.sections.billed_from.columns.for'))
                                            ->required()
                                            ->preload()
                                            ->native(false)
                                            ->searchable()
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                                $forType = $get('for_type');
                                                $forId = $get('for_id');
                                                if ($forType && $forId) {
                                                    $for = $forType::find($forId);
                                                    $set('name', $for->name);
                                                    $set('phone', $for->phone);
                                                    $set('address', $for->address);
                                                }
                                            })
                                            ->disabled(fn(Forms\Get $get) => !$get('for_type'))
                                            ->options(fn(Forms\Get $get) => $get('for_type') ? $get('for_type')::query()->pluck(FilamentInvoices::getFor()->where('model', $get('for_type'))->first()?->column ?? 'name', 'id')->toArray() : [])
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->columnSpan(6)
                                    ->collapsible()
                                    ->collapsed(fn($record) => $record),
                                Forms\Components\Section::make(trans('filament-invoices::messages.invoices.sections.customer_data.title'))
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label(trans('filament-invoices::messages.invoices.sections.customer_data.columns.name')),
                                        PhoneInput::make('phone')
                                            ->defaultCountry('PE')
                                            ->label(trans('filament-invoices::messages.invoices.sections.customer_data.columns.phone')),
                                        Forms\Components\Textarea::make('address')
                                            ->label(trans('filament-invoices::messages.invoices.sections.customer_data.columns.address')),
                                    ])
                                    ->columns(1)
                                    ->columnSpan(6)
                                    ->collapsible()
                                    ->collapsed(fn($record) => $record),
                                Forms\Components\Section::make(trans('filament-invoices::messages.invoices.sections.invoice_data.title'))
                                    ->schema([
                                        Forms\Components\DatePicker::make('date')
                                            ->label(trans('filament-invoices::messages.invoices.sections.invoice_data.columns.date'))
                                            ->native(false)
                                            ->required()
                                            ->default(Carbon::now()),
                                        Forms\Components\DatePicker::make('due_date')
                                            ->label(trans('filament-invoices::messages.invoices.sections.invoice_data.columns.due_date'))
                                            ->native(false)
                                            ->required()
                                            ->default(Carbon::now()->addDays(7)),
                                        Forms\Components\Select::make('type')
                                            ->label(trans('filament-invoices::messages.invoices.sections.invoice_data.columns.type'))
                                            ->required()
                                            ->default('push')
                                            ->searchable()
                                            ->options($types->pluck('name', 'key')->toArray()),
                                        Forms\Components\Select::make('status')
                                            ->label(trans('filament-invoices::messages.invoices.sections.invoice_data.columns.status'))
                                            ->required()
                                            ->default('draft')
                                            ->searchable()
                                            ->options($statues->pluck('name', 'key')->toArray()),
                                        Forms\Components\Select::make('currency_id')
                                            ->label(trans('filament-invoices::messages.invoices.sections.invoice_data.columns.currency'))
                                            ->required()
                                            ->columnSpanFull()
                                            ->default(Currency::query()->where('iso', 'PEN')->first()?->id)
                                            ->searchable()
                                            ->options(Currency::query()->pluck('name', 'id')->toArray()),
                                    ])
                                    ->columns(2)
                                    ->columnSpan(6)
                                    ->collapsible()
                                    ->collapsed(fn($record) => $record),
                            ]),
                        ]),
                    Forms\Components\Wizard\Step::make('Articulos')
                        ->schema([
                            Forms\Components\Repeater::make('items')
                                ->hiddenLabel()
                                ->collapsible()
                                ->collapsed(fn($record) => $record)
                                ->cloneable()
                                ->relationship('invoicesItems')
                                ->label(trans('filament-invoices::messages.invoices.columns.items'))
                                ->itemLabel(trans('filament-invoices::messages.invoices.columns.item'))
                                ->schema([
                                    Forms\Components\Select::make('product_id')
                                        ->relationship(name: 'product', titleAttribute: 'name')
                                        ->createOptionForm(self::product_schema())
                                        ->native(false)
                                        ->preload()
                                        ->searchable()
                                        ->label(trans('filament-invoices::messages.invoices.columns.item_name'))
                                        ->columnSpan(4),
                                    Forms\Components\TextInput::make('description')
                                        ->label(trans('filament-invoices::messages.invoices.columns.description'))
                                        ->columnSpan(8),
                                    Forms\Components\TextInput::make('qty')
                                        ->live()
                                        ->columnSpan(2)
                                        ->label(trans('filament-invoices::messages.invoices.columns.qty'))
                                        ->default(1)
                                        ->numeric(),
                                    Forms\Components\TextInput::make('price')
                                        ->label(trans('filament-invoices::messages.invoices.columns.price'))
                                        ->columnSpan(3)
                                        ->live(onBlur: true)
                                        ->default(0)
                                        ->numeric(),
                                    Forms\Components\TextInput::make('discount')
                                        ->label(trans('filament-invoices::messages.invoices.columns.discount'))
                                        ->columnSpan(2)
                                        ->default(0)
                                        ->numeric(),
                                    Forms\Components\TextInput::make('vat')
                                        ->label(trans('filament-invoices::messages.invoices.columns.vat'))
                                        ->columnSpan(2)
                                        ->default(0)
                                        ->numeric(),
                                    Forms\Components\TextInput::make('total')
                                        ->label(trans('filament-invoices::messages.invoices.columns.total'))
                                        ->columnSpan(3)
                                        ->default(0)
                                        ->numeric(),
                                ])
                                ->lazy()
                                ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                    $items = $get('items');
                                    $total = 0;
                                    $discount = 0;
                                    $vat = 0;
                                    $collectItems = [];
                                    foreach ($items as $invoiceItem) {
                                        $getTotal = ((($invoiceItem['price'] + $invoiceItem['vat']) - $invoiceItem['discount']) * $invoiceItem['qty']);
                                        $total += $getTotal;
                                        $invoiceItem['total'] = $getTotal;
                                        $discount += ($invoiceItem['discount'] * $invoiceItem['qty']);
                                        $vat +=  ($invoiceItem['vat'] * $invoiceItem['qty']);

                                        $collectItems[] = $invoiceItem;
                                    }
                                    $set('total', $total);
                                    $set('discount', $discount);
                                    $set('vat', $vat);

                                    $set('items', $collectItems);
                                })
                                ->columns(12)
                                ->columnSpanFull(),
                        ]),
                    Forms\Components\Wizard\Step::make('Totales')
                        ->schema([
                            Forms\Components\Section::make(trans('filament-invoices::messages.invoices.sections.totals.title'))
                                ->schema([
                                    MoneyInput::make('shipping')
                                        ->lazy()
                                        ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                            $items = $get('items');
                                            $total = 0;
                                            foreach ($items as $invoiceItem) {
                                                $total += ((($invoiceItem['price'] + $invoiceItem['vat']) - $invoiceItem['discount']) * $invoiceItem['qty']);
                                            }

                                            $set('total', $total + (int)$get('shipping'));
                                        })
                                        ->label(trans('filament-invoices::messages.invoices.columns.shipping'))
                                        ->default(0),
                                    MoneyInput::make('vat')
                                        ->disabled()
                                        ->label(trans('filament-invoices::messages.invoices.columns.vat'))
                                        ->default(0),
                                    MoneyInput::make('discount')
                                        // ->disabled()
                                        ->label(trans('filament-invoices::messages.invoices.columns.discount'))
                                        ->default(0),
                                    MoneyInput::make('total')
                                        ->disabled()
                                        ->label(trans('filament-invoices::messages.invoices.columns.total'))
                                        ->decimals(2)
                                        ->default(0),
                                    TinyEditor::make('notes')
                                        ->label(trans('filament-invoices::messages.invoices.columns.notes'))
                                        ->profile('minimal')
                                        ->columnSpanFull(),
                                ])->collapsible()->collapsed(fn($record) => $record),
                        ]),
                ])
                    ->columnSpanFull()
                    ->skippable()
                // Forms\Components\TextInput::make('uuid')
                //     ->unique(ignoreRecord: true)
                //     ->disabled(fn(Invoice $invoice) => $invoice->exists)
                //     ->label(trans('filament-invoices::messages.invoices.columns.uuid'))
                //     ->default(fn() => 'INV-' . \Illuminate\Support\Str::uuid())
                //     ->required()
                //     ->columnSpanFull()
                //     ->maxLength(255),

                // Forms\Components\Grid::make([
                //     'sm' => 1,
                //     'lg' => 12,
                // ])->schema([
                //     Forms\Components\Section::make(trans('filament-invoices::messages.invoices.sections.from_type.title'))
                //         ->schema([
                //             Forms\Components\Select::make('from_type')
                //                 ->label(trans('filament-invoices::messages.invoices.sections.from_type.columns.from_type'))
                //                 ->required()
                //                 ->searchable()
                //                 ->default(Company::class)
                //                 ->preload()
                //                 ->native(false)
                //                 ->live()
                //                 ->options(FilamentInvoices::getFrom()->pluck('label', 'model')->toArray())
                //                 ->columnSpanFull(),
                //             Forms\Components\Select::make('from_id')
                //                 ->label(trans('filament-invoices::messages.invoices.sections.from_type.columns.from'))
                //                 ->required()
                //                 ->searchable()
                //                 ->preload()
                //                 ->native(false)
                //                 ->disabled(fn(Forms\Get $get) => !$get('from_type'))
                //                 ->options(fn(Forms\Get $get) => $get('from_type') ? $get('from_type')::query()->pluck(FilamentInvoices::getFrom()->where('model', $get('from_type'))->first()?->column ?? 'name', 'id')->toArray() : [])
                //                 ->columnSpanFull(),
                //         ])
                //         ->columns(2)
                //         ->columnSpan(6)
                //         ->collapsible()
                //         ->collapsed(fn($record) => $record),
                //     Forms\Components\Section::make(trans('filament-invoices::messages.invoices.sections.billed_from.title'))
                //         ->schema([
                //             Forms\Components\Select::make('for_type')
                //                 ->label(trans('filament-invoices::messages.invoices.sections.billed_from.columns.for_type'))
                //                 ->searchable()
                //                 ->required()
                //                 ->live()
                //                 ->preload()
                //                 ->default(Customer::class)
                //                 ->native(false)
                //                 ->options(FilamentInvoices::getFor()->pluck('label', 'model')->toArray())
                //                 ->columnSpanFull(),
                //             Forms\Components\Select::make('for_id')
                //                 ->label(trans('filament-invoices::messages.invoices.sections.billed_from.columns.for'))
                //                 ->required()
                //                 ->preload()
                //                 ->native(false)
                //                 ->searchable()
                //                 ->live()
                //                 ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                //                     $forType = $get('for_type');
                //                     $forId = $get('for_id');
                //                     if ($forType && $forId) {
                //                         $for = $forType::find($forId);
                //                         $set('name', $for->name);
                //                         $set('phone', $for->phone);
                //                         $set('address', $for->address);
                //                     }
                //                 })
                //                 ->disabled(fn(Forms\Get $get) => !$get('for_type'))
                //                 ->options(fn(Forms\Get $get) => $get('for_type') ? $get('for_type')::query()->pluck(FilamentInvoices::getFor()->where('model', $get('for_type'))->first()?->column ?? 'name', 'id')->toArray() : [])
                //                 ->columnSpanFull(),
                //         ])
                //         ->columns(2)
                //         ->columnSpan(6)
                //         ->collapsible()
                //         ->collapsed(fn($record) => $record),
                //     Forms\Components\Section::make(trans('filament-invoices::messages.invoices.sections.customer_data.title'))
                //         ->schema([
                //             Forms\Components\TextInput::make('name')
                //                 ->label(trans('filament-invoices::messages.invoices.sections.customer_data.columns.name')),
                //             PhoneInput::make('phone')
                //                 ->defaultCountry('PE')
                //                 ->label(trans('filament-invoices::messages.invoices.sections.customer_data.columns.phone')),
                //             Forms\Components\Textarea::make('address')
                //                 ->label(trans('filament-invoices::messages.invoices.sections.customer_data.columns.address')),
                //         ])
                //         ->columns(1)
                //         ->columnSpan(6)
                //         ->collapsible()
                //         ->collapsed(fn($record) => $record),
                //     Forms\Components\Section::make(trans('filament-invoices::messages.invoices.sections.invoice_data.title'))
                //         ->schema([
                //             Forms\Components\DatePicker::make('date')
                //                 ->label(trans('filament-invoices::messages.invoices.sections.invoice_data.columns.date'))
                //                 ->native(false)
                //                 ->required()
                //                 ->default(Carbon::now()),
                //             Forms\Components\DatePicker::make('due_date')
                //                 ->label(trans('filament-invoices::messages.invoices.sections.invoice_data.columns.due_date'))
                //                 ->native(false)
                //                 ->required()
                //                 ->default(Carbon::now()->addDays(7)),
                //             Forms\Components\Select::make('type')
                //                 ->label(trans('filament-invoices::messages.invoices.sections.invoice_data.columns.type'))
                //                 ->required()
                //                 ->default('push')
                //                 ->searchable()
                //                 ->options($types->pluck('name', 'key')->toArray()),
                //             Forms\Components\Select::make('status')
                //                 ->label(trans('filament-invoices::messages.invoices.sections.invoice_data.columns.status'))
                //                 ->required()
                //                 ->default('draft')
                //                 ->searchable()
                //                 ->options($statues->pluck('name', 'key')->toArray()),
                //             Forms\Components\Select::make('currency_id')
                //                 ->label(trans('filament-invoices::messages.invoices.sections.invoice_data.columns.currency'))
                //                 ->required()
                //                 ->columnSpanFull()
                //                 ->default(Currency::query()->where('iso', 'PEN')->first()?->id)
                //                 ->searchable()
                //                 ->options(Currency::query()->pluck('name', 'id')->toArray()),
                //         ])
                //         ->columns(2)
                //         ->columnSpan(6)
                //         ->collapsible()
                //         ->collapsed(fn($record) => $record),
                // ]),
                // Forms\Components\Repeater::make('items')
                //     ->hiddenLabel()
                //     ->collapsible()
                //     ->collapsed(fn($record) => $record)
                //     ->cloneable()
                //     ->relationship('invoicesItems')
                //     ->label(trans('filament-invoices::messages.invoices.columns.items'))
                //     ->itemLabel(trans('filament-invoices::messages.invoices.columns.item'))
                //     ->schema([
                //         Forms\Components\Select::make('product_id')
                //             ->relationship(name: 'product', titleAttribute: 'name')
                //             ->native(false)
                //             ->preload()
                //             ->searchable()
                //             ->label(trans('filament-invoices::messages.invoices.columns.item_name'))
                //             ->columnSpan(4),
                //         Forms\Components\TextInput::make('description')
                //             ->label(trans('filament-invoices::messages.invoices.columns.description'))
                //             ->columnSpan(8),
                //         Forms\Components\TextInput::make('qty')
                //             ->live()
                //             ->columnSpan(2)
                //             ->label(trans('filament-invoices::messages.invoices.columns.qty'))
                //             ->default(1)
                //             ->numeric(),
                //         MoneyInput::make('price')
                //             ->label(trans('filament-invoices::messages.invoices.columns.price'))
                //             ->columnSpan(3)
                //             ->decimals(2)
                //             ->live(onBlur: true)
                //             ->default(0),
                //         MoneyInput::make('discount')
                //             ->label(trans('filament-invoices::messages.invoices.columns.discount'))
                //             ->columnSpan(2)
                //             ->default(0),
                //         MoneyInput::make('vat')
                //             ->label(trans('filament-invoices::messages.invoices.columns.vat'))
                //             ->columnSpan(2)
                //             ->default(0),
                //         MoneyInput::make('total')
                //             ->label(trans('filament-invoices::messages.invoices.columns.total'))
                //             ->columnSpan(3)
                //             ->default(0),
                //     ])
                //     ->lazy()
                //     ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                //         $items = $get('items');
                //         $total = 0;
                //         $discount = 0;
                //         $vat = 0;
                //         $collectItems = [];
                //         foreach ($items as $invoiceItem) {
                //             $getTotal = ((($invoiceItem['price'] + $invoiceItem['vat']) - $invoiceItem['discount']) * $invoiceItem['qty']);
                //             $total += $getTotal;
                //             $invoiceItem['total'] = $getTotal;
                //             $discount += ($invoiceItem['discount'] * $invoiceItem['qty']);
                //             $vat +=  ($invoiceItem['vat'] * $invoiceItem['qty']);

                //             $collectItems[] = $invoiceItem;
                //         }
                //         $set('total', number_format($total, 2));
                //         $set('discount', $discount);
                //         $set('vat', $vat);

                //         $set('items', $collectItems);
                //     })
                //     ->columns(12)
                //     ->columnSpanFull(),
                // Forms\Components\Section::make(trans('filament-invoices::messages.invoices.sections.totals.title'))
                //     ->schema([
                //         MoneyInput::make('shipping')
                //             ->lazy()
                //             ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                //                 $items = $get('items');
                //                 $total = 0;
                //                 foreach ($items as $invoiceItem) {
                //                     $total += ((($invoiceItem['price'] + $invoiceItem['vat']) - $invoiceItem['discount']) * $invoiceItem['qty']);
                //                 }

                //                 $set('total', $total + (int)$get('shipping'));
                //             })
                //             ->label(trans('filament-invoices::messages.invoices.columns.shipping'))
                //             ->default(0),
                //         MoneyInput::make('vat')
                //             ->disabled()
                //             ->label(trans('filament-invoices::messages.invoices.columns.vat'))
                //             ->default(0),
                //         MoneyInput::make('discount')
                //             // ->disabled()
                //             ->label(trans('filament-invoices::messages.invoices.columns.discount'))
                //             ->default(0),
                //         MoneyInput::make('total')
                //             ->disabled()
                //             ->label(trans('filament-invoices::messages.invoices.columns.total'))
                //             ->decimals(2)
                //             ->default(0),
                //         TinyEditor::make('notes')
                //             ->label(trans('filament-invoices::messages.invoices.columns.notes'))
                //             ->profile('minimal')
                //             ->columnSpanFull(),
                //     ])->collapsible()->collapsed(fn($record) => $record),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInvoices::route('/'),
            'create' => CreateInvoice::route('/create'),
            'edit' => EditInvoice::route('/{record}/edit'),
            'view' => ViewInvoice::route('/{record}/show'),
        ];
    }
}
