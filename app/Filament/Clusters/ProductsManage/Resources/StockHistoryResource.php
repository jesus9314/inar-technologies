<?php

namespace App\Filament\Clusters\ProductsManage\Resources;

use App\Filament\Clusters\ProductsManage;
use App\Filament\Clusters\ProductsManage\Resources\StockHistoryResource\Pages;
use App\Filament\Clusters\ProductsManage\Resources\StockHistoryResource\Pages\StockHistoryActivityLogPage;
use App\Filament\Clusters\ProductsManage\Resources\StockHistoryResource\RelationManagers;
use App\Models\StockHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockHistoryResource extends Resource
{
    protected static ?string $model = StockHistory::class;

    protected static ?string $navigationIcon = 'heroicon-c-document-magnifying-glass';

    protected static ?string $modelLabel = 'Historial de Stock de Producto';

    protected static ?string $pluralModelLabel = 'Historial de Stock de Productos';

    protected static ?string $navigationGroup = 'Adicional';

    protected static ?string $cluster = ProductsManage::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                Forms\Components\Select::make('action_id')
                    ->relationship('action', 'id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Producto')
                    ->sortable(),
                Tables\Columns\TextColumn::make('old_quantity')
                    ->label('Stock antiguo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('new_quantity')
                    ->label('Stock nuevo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('action.description')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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
                    Tables\Actions\Action::make('activities')->url(fn ($record) => StockHistoryResource::getUrl('activities', ['record' => $record])),
                    // Tables\Actions\EditAction::make(),
                    // Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageStockHistories::route('/'),
            'activities' => StockHistoryActivityLogPage::route('/{record}/activities'),
        ];
    }
}
