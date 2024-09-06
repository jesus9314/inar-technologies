<?php

namespace App\Filament\Clusters\AditionalInformation\Resources;

use App\Filament\Clusters\AditionalInformation;
use App\Filament\Clusters\AditionalInformation\Resources\CompanyResource\Pages;
use App\Filament\Clusters\AditionalInformation\Resources\CompanyResource\RelationManagers;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $cluster = AditionalInformation::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('logo')
                            // ->label(trans('filament-ecommerce::messages.company.columns.logo'))
                            ->collection('logo')
                            ->columnSpanFull()
                            ->image(),
                        Forms\Components\TextInput::make('name')
                            ->columnSpanFull()
                            // ->label(trans('filament-ecommerce::messages.company.columns.name'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            // ->label(trans('filament-ecommerce::messages.company.columns.email'))
                            ->email()
                            ->maxLength(255),
                        PhoneInput::make('phone')
                            ->defaultCountry('PE'),
                        // Forms\Components\TextInput::make('phone')
                        //     // ->label(trans('filament-ecommerce::messages.company.columns.phone'))
                        //     ->tel()
                        //     ->maxLength(255),
                        Forms\Components\TextInput::make('website')
                            ->url()
                            // ->label(trans('filament-ecommerce::messages.company.columns.website'))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('ceo')
                            // ->label(trans('filament-ecommerce::messages.company.columns.ceo'))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('registration_number')
                            // ->label(trans('filament-ecommerce::messages.company.columns.registration_number'))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tax_number')
                            // ->label(trans('filament-ecommerce::messages.company.columns.tax_number'))
                            ->maxLength(255),
                        Forms\Components\Textarea::make('notes')
                            // ->label(trans('filament-ecommerce::messages.company.columns.notes'))
                            ->columnSpanFull(),
                    ])->columns(2),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->columnSpanFull()
                            // ->label(trans('filament-ecommerce::messages.company.columns.address'))
                            ->maxLength(255),
                        Forms\Components\Select::make('country_id')
                            ->searchable()
                            ->relationship(name: 'country', titleAttribute: 'name')
                            ->preload(),
                        // ->label(trans('filament-ecommerce::messages.company.columns.country_id')),
                        Forms\Components\TextInput::make('city')
                            // ->label(trans('filament-ecommerce::messages.company.columns.city'))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('zip')
                            ->columnSpanFull()
                            // ->label(trans('filament-ecommerce::messages.company.columns.zip'))
                            ->maxLength(255),

                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country.name')
                    ->label(trans('filament-ecommerce::messages.company.columns.country_id'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('filament-ecommerce::messages.company.columns.name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(trans('filament-ecommerce::messages.company.columns.email'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(trans('filament-ecommerce::messages.company.columns.phone'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCompanies::route('/'),
        ];
    }
}
