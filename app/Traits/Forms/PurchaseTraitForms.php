<?php

namespace App\Traits\Forms;

use App\Traits\TraitForms;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Database\Eloquent\Builder;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;

trait PurchaseTraitForms
{
    use SupplierTraitForms, TraitForms;

    private static $files_accepted = [
        'application/pdf',
        'image/jpeg',
        'image/png'
    ];

    public static function purchase_form(): array
    {
        return [
            Wizard::make()
                ->schema([
                    Step::make('Datos del Comprobante')
                        ->schema(self::voucher_data())
                        ->columns(2),
                    Step::make('Productos y Servicios')
                        ->schema(self::product_service_form()),
                    Step::make('Resumen de Compra')
                        ->schema(self::summary_form())
                        ->columns(3),
                    Step::make('Comprobantes')
                        ->schema(self::vouchers_form())
                        ->columns([
                            'sm' => 1,
                            'md' => 2,
                            '2xl' => 3
                        ]),
                ])
                ->columnSpanFull()
                ->skippable(),
        ];
    }

    public static function voucher_data(): array
    {
        return [
            DatePicker::make('date_of_issue')
                ->label('Fecha de Emisión')
                ->native(false)
                ->required(),
            DatePicker::make('date_of_reception')
                ->label('Fecha de Recepción')
                ->native(false)
                ->required(),
            TextInput::make('series')
                ->label('Serie')
                ->required()
                ->maxLength(255),
            TextInput::make('number')
                ->label('Número')
                ->required()
                ->maxLength(255),
            Select::make('tax_document_type_id')
                ->label('Tipo de documento')
                ->relationship('taxDocumentType', 'description')
                ->default(2)
                ->searchable()
                ->preload()
                ->required(),
            Select::make('supplier_id')
                ->label('Proveedors')
                ->relationship('supplier', 'name')
                ->createOptionForm(self::supplier_form())
                ->searchable()
                ->preload()
                ->required(),
            Select::make('currency_id')
                ->label('Moneda')
                ->relationship('currency', 'description')
                ->default(1)
                ->searchable()
                ->preload()
                ->required(),
            Select::make('action_id')
                ->label('Acción')
                ->disabled()
                ->relationship('action', 'description')
                ->searchable()
                ->default(1)
                ->preload()
                ->required(),
        ];
    }

    public static function product_service_form(): array
    {
        return [
            TableRepeater::make('productPurchase')
                ->label('Productos')
                ->relationship()
                ->live(onBlur: true)
                ->afterStateUpdated(function (Get $get, Set $set, $state) {
                    self::updatePrices($set, $get);
                })
                ->deleteAction(
                    fn (Action $action) => $action->after(fn (Get $get, Set $set) => self::updatePrices($set, $get)),
                )
                ->schema([
                    Select::make('product_id')
                        ->relationship('product', 'name')
                        ->native(false)
                        ->label('Nombre')
                        ->searchable()
                        ->live(onBlur: true)
                        ->preload()
                        ->required()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::updatePSPrices($get, $set);
                        })
                        ->disableOptionWhen(function ($value, $state, Get $get) {
                            return collect($get('../*.product_id'))
                                ->reject(fn ($id) => $id == $state)
                                ->filter()
                                ->contains($value);
                        })
                        ->createOptionForm(self::product_form()),
                    TextInput::make('quantity')
                        ->required()
                        ->label('Cantidad')
                        ->integer()
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::updatePSPrices($get, $set);
                        })
                        ->live(onBlur: true)
                        ->numeric(),
                    MoneyInput::make('price')
                        ->required()
                        ->label('Precio')
                        ->currency('PEN')
                        ->locale('es_PE')
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::updatePSPrices($get, $set);
                        })
                        ->numeric(),
                    MoneyInput::make('igv')
                        ->required()
                        ->label('I.G.V')
                        ->currency('PEN')
                        ->locale('es_PE')
                        ->disabled()
                        ->live()
                        ->numeric(),
                    MoneyInput::make('total_price')
                        ->required()
                        ->disabled()
                        ->currency('PEN')
                        ->locale('es_PE')
                        ->label('Precio Total')
                        ->numeric(),
                ]),
        ];
    }

    public static function summary_form(): array
    {
        return [
            MoneyInput::make('price')
                ->label('Precio')
                ->currency('PEN')
                ->locale('es_PE')
                ->readOnly()
                ->disabled()
                ->live(onBlur: true)
                ->afterStateHydrated(function (Set $set, Get $get) {
                    self::updatePrices($set, $get);
                }),
            MoneyInput::make('igv')
                ->label('I.G.V')
                ->currency('PEN')
                ->locale('es_PE')
                ->disabled()
                ->step('0.01'),
            MoneyInput::make('total_price')
                ->label('Precio Total')
                ->currency('PEN')
                ->locale('es_PE')
                ->disabled(),
        ];
    }

    public static function vouchers_form(): array
    {
        return [
            TableRepeater::make('vouchers')
                ->label('Comprobantes')
                ->relationship()
                ->columnSpanFull()
                ->defaultItems(0)
                ->simple(
                    FileUpload::make('document_url')
                        ->label('Archivos')
                        ->required()
                        ->directory('purchase-vouchers')
                        ->helperText(self::get_files_accepted_message())
                        ->acceptedFileTypes(self::$files_accepted),
                )
        ];
    }


    public static function updatePSPrices(Get $get, Set $set): void
    {
        if ($get('product_id') != null && $get('quantity') != null && $get('price') != null) {
            $quantity = $get('quantity');
            $price = $get('price');
            $subtotal = $price * $quantity;
            $igv = ($subtotal) * 0.18;
            $total_price = $subtotal + $igv;

            $set('igv', $igv);
            $set('total_price', $total_price);
        }
    }

    public static function updatePrices(Set $set, Get $get): void
    {
        $selectedProducts  = collect($get('productPurchase'))->filter(fn ($item) => !empty($item['product_id']) && !empty($item['quantity']) && !empty($item['price']));
        $price = $selectedProducts->reduce(function ($subtotal, $product) {
            return $subtotal + ($product['quantity'] * $product['price']);
        });
        $igv = $price * 0.18;
        $total = $price + $igv;


        $set('price', $price);
        $set('igv', $igv);
        $set('total_price', $total);
    }

    public static function get_files_accepted_message(): string
    {
        $message = "Archivos aceptados: ";
        for ($i = 0; $i < count(self::$files_accepted); $i++) {
            if ($i > 0) {
                $message .= ', ';
            }
            $file_name = explode('/', self::$files_accepted[$i])[1];
            $message .=  $file_name;
        }
        return $message;
    }
}
