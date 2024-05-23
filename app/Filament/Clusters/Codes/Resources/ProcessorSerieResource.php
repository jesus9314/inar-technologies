<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\ProcessorSerieResource\Pages;
use App\Filament\Clusters\Codes\Resources\ProcessorSerieResource\RelationManagers;
use App\Models\ProcessorSerie;
use App\Traits\Forms\DevicesTraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProcessorSerieResource extends Resource
{
    use DevicesTraitForms;

    protected static ?string $model = ProcessorSerie::class;

    protected static ?string $navigationIcon = 'heroicon-m-receipt-percent';

    protected static ?string $navigationGroup = 'Procesador';

    protected static ?string $modelLabel = 'Series de procesadores';

    protected static ?string $pluralModelLabel = 'series de procesadores';


    protected static ?string $cluster = Codes::class;

    public static function form(Form $form): Form
    {
        return self::processor_serie_form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('processorManufacturer.name')
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
            'index' => Pages\ManageProcessorSeries::route('/'),
        ];
    }
}
