<?php

namespace App\Filament\Clusters\Devices\Resources;

use App\Filament\Clusters\Devices;
use App\Filament\Clusters\Devices\Resources\StorageResource\Pages;
use App\Filament\Clusters\Devices\Resources\StorageResource\RelationManagers;
use App\Models\Storage;
use App\Traits\Forms\DevicesTraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StorageResource extends Resource
{
    use DevicesTraitForms;

    protected static ?string $model = Storage::class;

    protected static ?string $navigationIcon = 'heroicon-c-circle-stack';

    protected static ?string $cluster = Devices::class;

    protected static ?string $navigationGroup = 'Componentes';

    protected static ?string $navigationLabel = 'Almacenamientos';

    protected static ?string $modelLabel = 'almacenamiento';

    protected static ?string $pluralModelLabel = 'almacenamientos';

    public static function form(Form $form): Form
    {
        return self::storage_form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\IconColumn::make('auto_name')
                    ->boolean(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('interface')
                    ->searchable(),
                Tables\Columns\TextColumn::make('form_factor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('read_speed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('write_speed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('specs_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand_id')
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
            'index' => Pages\ListStorages::route('/'),
            'create' => Pages\CreateStorage::route('/create'),
            'view' => Pages\ViewStorage::route('/{record}'),
            'edit' => Pages\EditStorage::route('/{record}/edit'),
        ];
    }
}
