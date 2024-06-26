<?php

namespace App\Filament\Clusters\Devices\Resources;

use App\Filament\Clusters\Devices;
use App\Filament\Clusters\Devices\Resources\PeripheralResource\Pages;
use App\Filament\Clusters\Devices\Resources\PeripheralResource\RelationManagers;
use App\Models\Peripheral;
use App\Traits\Forms\DevicesTraitForms;
use App\Traits\TraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeripheralResource extends Resource
{
    use DevicesTraitForms;

    protected static ?string $model = Peripheral::class;

    protected static ?string $navigationIcon = 'heroicon-s-cube-transparent';

    protected static ?string $navigationGroup = 'Componentes';

    protected static ?string $navigationLabel = 'Periféricos';

    protected static ?string $modelLabel = 'periférico';

    protected static ?string $pluralModelLabel = 'periféricos';


    protected static ?string $cluster = Devices::class;

    public static function form(Form $form): Form
    {
        return self::peripheral_form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_url'),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('peripheralType.id')
                    ->numeric()
                    ->sortable(),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManagePeripherals::route('/'),
        ];
    }
}
