<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\ProcessorConditionResource\Pages;
use App\Filament\Clusters\Codes\Resources\ProcessorConditionResource\RelationManagers;
use App\Models\ProcessorCondition;
use App\Traits\Forms\TraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProcessorConditionResource extends Resource
{
    use TraitForms;

    protected static ?string $model = ProcessorCondition::class;

    protected static ?string $navigationIcon = 'heroicon-m-beaker';

    protected static ?string $navigationGroup = 'Procesador';

    protected static ?string $modelLabel = 'Condición de Procesadores';

    protected static ?string $pluralModelLabel = 'Condiciones de Procesadores';

    protected static ?string $cluster = Codes::class;

    public static function form(Form $form): Form
    {
        return self::processor_condition_form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
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
            'index' => Pages\ManageProcessorConditions::route('/'),
        ];
    }
}
