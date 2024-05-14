<?php

namespace App\Traits\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

trait ServiceTraitForms
{
    use ProductTraitForms;

    private static function service_form(Form $form): Form
    {
        return $form
            ->schema(self::service_schema());
    }

    public static function service_schema(): array
    {
        return [
            Wizard::make([
                Step::make('Información del servicio')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, $state) => $set('slug', Str::slug($state)))
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->readOnly()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('description')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),
                Step::make('Información del producto')
                    ->schema([
                        Repeater::make('product')
                            ->relationship()
                            ->schema(self::product_info_schema())
                            ->label('Datos de Producto')
                            ->addable(false)
                            ->deletable(false)
                            ->defaultItems(1)
                            ->columns(2)
                    ]),
                Step::make('Relaciones')
                    ->schema(self::service_relations_form())
                    ->columns(2),

            ])
                ->columnSpanFull()
                ->skippable()
        ];
    }

    protected static function product_info_schema(): array
    {
        return [
            TextInput::make('secondary_name')
                ->label('Nombre secundario')
                ->maxLength(255),
            TextInput::make('bar_code')
                ->label('Código de Barras')
                ->maxLength(255),
            TextInput::make('internal_code')
                ->label('Código Interno')
                ->maxLength(255),
            MoneyInput::make('unity_price')
                ->label('Precio Unitario')
                ->required(),
            FileUpload::make('image_url')
                ->label('Imagen del producto')
                ->image()
                ->columnSpan(2),
        ];
    }

    protected static function service_relations_form(): array
    {
        return [
            Select::make('affectation_id')
                ->label('Tipos de afectación al IGV')
                ->searchable()
                ->preload()
                ->relationship('affectation', 'description')
                ->default(1),
            Select::make('category_id')
                ->label('Categoría')
                ->createOptionForm(self::category_schema())
                ->searchable()
                ->preload()
                ->relationship('category', 'name'),
            Select::make('currency_id')
                ->label('Moneda')
                ->searchable()
                ->preload()
                ->relationship('currency', 'description')
                ->default(1),
        ];
    }
}
