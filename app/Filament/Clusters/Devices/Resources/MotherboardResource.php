<?php

namespace App\Filament\Clusters\Devices\Resources;

use App\Filament\Clusters\Devices;
use App\Filament\Clusters\Devices\Resources\MotherboardResource\Pages;
use App\Filament\Clusters\Devices\Resources\MotherboardResource\RelationManagers;
use App\Models\Motherboard;
use App\Traits\Forms\DevicesTraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MotherboardResource extends Resource
{
    use DevicesTraitForms;

    protected static ?string $model = Motherboard::class;

    protected static ?string $navigationIcon = 'heroicon-c-document-text';

    protected static ?string $navigationGroup = 'Componentes';

    protected static ?string $navigationLabel = 'Tarjetas Madre';

    protected static ?string $modelLabel = 'tarjeta madre';

    protected static ?string $pluralModelLabel = 'tarjetas madre';

    protected static ?string $cluster = Devices::class;

    public static function form(Form $form): Form
    {
        return self::motherboard_form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('form_factor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('socket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('chipset')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name')
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMotherboards::route('/'),
            'create' => Pages\CreateMotherboard::route('/create'),
            'view' => Pages\ViewMotherboard::route('/{record}'),
            'edit' => Pages\EditMotherboard::route('/{record}/edit'),
        ];
    }
}
