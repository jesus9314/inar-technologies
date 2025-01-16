<?php

namespace App\Filament\Clusters\Maintenances\Resources;

use App\Filament\Clusters\Maintenances;
use App\Filament\Clusters\Maintenances\Resources\MaintenanceResource\Pages;
use App\Filament\Clusters\Maintenances\Resources\MaintenanceResource\RelationManagers;
use App\Models\Maintenance;
use App\Traits\Forms\MaintenanceTraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Torgodly\Html2Media\Actions\Html2MediaAction;

class MaintenanceResource extends Resource
{
    use MaintenanceTraitForms;

    protected static ?string $model = Maintenance::class;

    protected static ?string $navigationIcon = 'heroicon-c-cog-6-tooth';

    protected static ?string $cluster = Maintenances::class;

    protected static ?string $navigationLabel = 'Mantenimientos';

    public static function form(Form $form): Form
    {
        return self::maintenance_form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('maintenanceState.name')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('device.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
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
            'index' => Pages\ListMaintenances::route('/'),
            'create' => Pages\CreateMaintenance::route('/create'),
            'view' => Pages\ViewMaintenance::route('/{record}'),
            'edit' => Pages\EditMaintenance::route('/{record}/edit'),
        ];
    }
}
