<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiResource\Pages;
use App\Filament\Resources\ApiResource\RelationManagers;
use App\Models\Api;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApiResource extends Resource
{
    protected static ?string $model = Api::class;

    protected static ?string $navigationIcon = 'heroicon-c-cursor-arrow-ripple';

    protected static ?string $navigationGroup = 'Configuraciones';

    protected static ?string $modelLabel = 'API';

    protected static ?string $pluralModelLabel = 'APIs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('env_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('documentation_link')
                    ->prefix('https://')
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('documentation_link')
                    ->url(fn (Api $api) => $api->documentation_link)
                    ->openUrlInNewTab()
                    ->searchable(),
                Tables\Columns\TextColumn::make('env_name')
                    ->copyable()
                    ->copyMessage('Variable de entorno Copiada')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
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
                    Action::make('active')
                        ->label(fn (Api $api) => self::getActiveLabel($api))
                        ->icon(fn (Api $api) => self::getActiveIcon($api))
                        ->requiresConfirmation()
                        ->action(fn (Api $api) => self::changeStatus($api))
                        ->modalHeading(fn (Api $api) => self::getActiveModalHeading($api))
                        ->modalDescription(fn (Api $api) => self::getActiveModalDescription($api)),
                    // Tables\Actions\EditAction::make()
                    //     ->requiresConfirmation()
                    //     ->modalDescription('Considera que habilitar una api puede incluir costos de facturación'),
                    // Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getActiveModalDescription(Api $api): string
    {
        return $api->status ? 'Desactivar esta api conlleva deshabilitar funcionalidades que podrían ser importantes en el sistema' : 'Considera que activar una API puede incluir costos de facturación y debe haber una clave configurada en las variables de entorno, sino no funcionará ';
    }

    public static function getActiveModalHeading(Api $api): string
    {
        return $api->status ? 'Estás seguro que deseas Desactivar esta API?' : 'Estás seguro que deseas Activar esta API?';
    }

    public static function getActiveIcon(Api $api): string
    {
        return $api->status ? 'heroicon-o-bolt-slash' : 'heroicon-o-bolt';
    }

    public static function getActiveLabel(Api $api): string
    {
        return $api->status ? 'Desactivar' : 'Activar';
    }

    public static function changeStatus(Api $api): void
    {
        $api->status = !$api->status;
        $api->save();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageApis::route('/'),
        ];
    }
}
