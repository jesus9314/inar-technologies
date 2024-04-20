<?php

namespace App\Filament\Clusters\Devices\Resources;

use App\Filament\Clusters\Devices;
use App\Filament\Clusters\Devices\Resources\RamResource\Pages;
use App\Filament\Clusters\Devices\Resources\RamResource\RelationManagers;
use App\Models\Ram;
use App\Traits\TraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RamResource extends Resource
{
    use TraitForms;

    protected static ?string $model = Ram::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Devices::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::ram_form());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('speed')
                    ->searchable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('latency')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_url'),
                Tables\Columns\TextColumn::make('specifications_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ramFormFactor.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('memoryType.id')
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
            'index' => Pages\ListRams::route('/'),
            'create' => Pages\CreateRam::route('/create'),
            'view' => Pages\ViewRam::route('/{record}'),
            'edit' => Pages\EditRam::route('/{record}/edit'),
        ];
    }
}
