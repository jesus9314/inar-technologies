<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\DeviceStateResource\Pages;
use App\Filament\Clusters\Codes\Resources\DeviceStateResource\RelationManagers;
use App\Models\DeviceState;
use App\Traits\Forms\DevicesTraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeviceStateResource extends Resource
{
    use DevicesTraitForms;

    protected static ?string $model = DeviceState::class;

    protected static ?string $navigationIcon = 'heroicon-m-server-stack';

    protected static ?string $navigationGroup = 'Dispositivos';

    protected static ?string $modelLabel = 'Estados de dispositivos';

    protected static ?string $pluralModelLabel = 'estados de dispositivos';

    protected static ?string $cluster = Codes::class;

    public static function form(Form $form): Form
    {
        return self::device_state_form($form);
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
            'index' => Pages\ManageDeviceStates::route('/'),
        ];
    }
}
