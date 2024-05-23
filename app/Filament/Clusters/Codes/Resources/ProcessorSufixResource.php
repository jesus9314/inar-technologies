<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\ProcessorSufixResource\Pages;
use App\Filament\Clusters\Codes\Resources\ProcessorSufixResource\RelationManagers;
use App\Models\ProcessorSufix;
use App\Traits\Forms\DevicesTraitForms;
use App\Traits\Forms\TraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProcessorSufixResource extends Resource
{
    use DevicesTraitForms;

    protected static ?string $model = ProcessorSufix::class;

    protected static ?string $navigationIcon = 'heroicon-c-light-bulb';

    protected static ?string $navigationGroup = 'Procesador';

    protected static ?string $modelLabel = 'Sufijos de procesadores';

    protected static ?string $pluralModelLabel = 'sufijos de procesadores';

    protected static ?string $cluster = Codes::class;

    public static function form(Form $form): Form
    {
        return self::processor_sufix_form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('processor_manufacturer.name')
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
            'index' => Pages\ManageProcessorSufixes::route('/'),
        ];
    }
}
