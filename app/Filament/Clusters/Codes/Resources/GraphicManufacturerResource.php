<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\GraphicManufacturerResource\Pages;
use App\Filament\Clusters\Codes\Resources\GraphicManufacturerResource\RelationManagers;
use App\Models\GraphicManufacturer;
use App\Traits\Forms\DevicesTraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GraphicManufacturerResource extends Resource
{
    use DevicesTraitForms;

    protected static ?string $model = GraphicManufacturer::class;

    protected static ?string $navigationIcon = 'heroicon-c-qr-code';

    protected static ?string $navigationGroup = 'Tarjetas Gráficas';

    protected static ?string $modelLabel = 'Fabricantes de gráficas';

    protected static ?string $pluralModelLabel = 'fabricantes de gráficas';

    protected static ?string $cluster = Codes::class;

    public static function form(Form $form): Form
    {
        return self::graphic_manufacturer_form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
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
            'index' => Pages\ManageGraphicManufacturers::route('/'),
        ];
    }
}
