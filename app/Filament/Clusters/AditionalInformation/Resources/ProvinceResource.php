<?php

namespace App\Filament\Clusters\AditionalInformation\Resources;

use App\Filament\Clusters\AditionalInformation;
use App\Filament\Clusters\AditionalInformation\Resources\ProvinceResource\Pages;
use App\Filament\Clusters\AditionalInformation\Resources\ProvinceResource\RelationManagers;
use App\Models\Province;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProvinceResource extends Resource
{
    protected static ?string $model = Province::class;

    protected static ?string $cluster = AditionalInformation::class;

    protected static ?string $navigationIcon = 'heroicon-c-moon';

    protected static ?string $navigationGroup = 'Ubigeo';

    protected static ?string $modelLabel = 'Provincia';

    protected static ?string $pluralModelLabel = 'Provincias';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Select::make('country_id')
                    ->relationship('country', 'name')
                    ->searchable()
                    ->preload()
                    ->live(onBlur: true)
                    ->required(),
                Forms\Components\Select::make('department_id')
                    ->live()
                    ->relationship(
                        name: 'department',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('country_id', $get('country_id'))
                    )
                    ->disabled(fn (Get $get): bool => !filled($get('country_id')))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('country.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ManageProvinces::route('/'),
        ];
    }
}
