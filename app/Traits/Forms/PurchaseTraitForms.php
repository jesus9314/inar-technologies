<?php

namespace App\Traits\Forms;

use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;
use Illuminate\Database\Eloquent\Builder;

trait PurchaseTraitForms
{
    use SupplierTraitForms, TraitForms, ProductTraitForms, ServiceTraitForms;

    private static $files_accepted = [
        'application/pdf',
        'image/jpeg',
        'image/png'
    ];

    protected static function purchase_form(Form $form): Form
    {
        return $form
            ->schema(self::purchase_schema());
    }

    public static function purchase_schema(): array
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
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Get $get, Set $set) => self::set_reception_date($get, $set))
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
                ->relationship('productPurchase')
                ->live(onBlur: true)
                ->afterStateUpdated(function (Get $get, Set $set, $state) {
                    self::updatePrices($set, $get);
                })
                ->deleteAction(
                    fn (Action $action) => $action->after(fn (Get $get, Set $set) => self::updatePrices($set, $get)),
                )
                ->emptyLabel('Aún no hay Productos registrados')
                ->headers([
                    Header::make('Producto'),
                    Header::make('Cantidad'),
                    Header::make('Precio'),
                    Header::make('IGV'),
                    Header::make('Precio Total'),

                ])
                ->schema(self::products_schema())
                ->defaultItems(0),
            TableRepeater::make('purchaseService')
                ->label('Servicios')
                ->relationship('purchaseService')
                ->live(onBlur: true)
                ->afterStateUpdated(function (Get $get, Set $set, $state) {
                    self::updatePrices($set, $get);
                })
                ->deleteAction(
                    fn (Action $action) => $action->after(fn (Get $get, Set $set) => self::updatePrices($set, $get)),
                )
                ->emptyLabel('Aún no hay servicios registrados')
                ->headers([
                    Header::make('Servicio'),
                    Header::make('Precio'),
                    Header::make('IGV'),
                    Header::make('Precio Total'),
                ])
                ->schema(self::services_schema())
                ->defaultItems(0)
        ];
    }

    protected static function products_schema(): array
    {
        return [
            Select::make('product_id')
                ->relationship(
                    name: 'product',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn (Builder $query) => $query->where('service_id', null)
                )
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
                ->createOptionForm(self::product_schema()),
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
                }),
            MoneyInput::make('igv')
                ->required()
                ->label('I.G.V')
                ->reactive()
                ->disabled()
                ->dehydrated()
                ->live()
                ->numeric(),
            MoneyInput::make('total_price')
                ->required()
                ->reactive()
                ->disabled()
                ->dehydrated()
                ->label('Precio Total')
                ->numeric(),
        ];
    }

    protected static function services_schema(): array
    {
        return [
            Select::make('service_id')
                ->relationship('service', 'name')
                ->preload()
                ->searchable()
                ->native(false)
                ->live(onBlur: true)
                ->required()
                ->afterStateUpdated(fn (Get $get, Set $set) => self::updateServicePrice($get, $set))
                ->disableOptionWhen(function ($value, $state, Get $get) {
                    return collect($get('../*.service_id'))
                        ->reject(fn ($id) => $id == $state)
                        ->filter()
                        ->contains($value);
                })
                ->createOptionForm(self::service_schema()),
            MoneyInput::make('price')
                ->label('Precio')
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Get $get, Set $set) => self::updateServicePrice($get, $set))
                ->required(),
            MoneyInput::make('igv')
                ->label('I.G.V.')
                ->required()
                ->disabled()
                ->dehydrated(),
            MoneyInput::make('total_price')
                ->label('Precio Total')
                ->required()
                ->disabled()
                ->dehydrated(),

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
                ->emptyLabel('Aún no hay comprobantes registrados')
                ->label('Comprobantes')
                ->relationship()
                ->columnSpanFull()
                ->defaultItems(0)
                ->headers([
                    Header::make('Documento')
                ])
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

    public static function set_reception_date(Get $get, Set $set): void
    {
        $set('date_of_reception', $get('date_of_issue'));
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

    public static function updateServicePrice(Get $get, Set $set): void
    {
        if (($get('service_id') != null) && ($get('price') != null)) {
            $igv =  $get('price') * 0.18;
            $total_price = $get('price') + $igv;

            $set('igv', $igv);
            $set('total_price', $total_price);
        }
    }

    public static function updatePrices(Set $set, Get $get): void
    {
        $selectedProducts  = collect($get('productPurchase'))->filter(fn ($item) => !empty($item['product_id']) && !empty($item['quantity']) && !empty($item['price']));
        $product_price = $selectedProducts->reduce(function ($subtotal, $product) {
            return $subtotal + ($product['quantity'] * $product['price']);
        });

        $selectedServices = collect($get('purchaseService'))->filter(fn ($item) => !empty($item['service_id']) && !empty($item['price']));
        $service_price = $selectedServices->reduce(fn ($subtotal, $service) => $subtotal + $service['price']);

        $price = $product_price + $service_price;

        // dd($price);

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
