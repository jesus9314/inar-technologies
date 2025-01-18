<?php

namespace App\Tratis\Tables;

use App\Filament\Clusters\ProductsManage\Resources\ProductResource;
use App\Filament\Exports\ProductExporter;
use App\Filament\Imports\ProductImporter;
use App\Models\Product;
use Filament\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\NumberConstraint;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

trait ProductTraitTable
{
    protected static function product_table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->where('service_id', null))
            ->extremePaginationLinks()
            ->striped()
            ->groups(self::groups())
            ->headerActions(self::headers())
            ->columns(self::columns())
            ->filters(self::filters())
            ->persistFiltersInSession()
            ->actions(self::actions(), position: ActionsPosition::BeforeColumns)
            ->bulkActions(self::bulkActions());
    }

    protected static function bulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
                ForceDeleteBulkAction::make(),
                RestoreBulkAction::make(),
                ExportBulkAction::make()
                    ->exporter(ProductExporter::class)
            ]),
        ];
    }

    protected static function headers(): array
    {
        return [
            // ExportAction::make()
            //     ->exporter(ProductExporter::class),
            // ImportAction::make()
            //     ->importer(ProductImporter::class),
        ];
    }

    protected static function filters(): array
    {
        return [
            TrashedFilter::make(),
            TernaryFilter::make('service'),
            SelectFilter::make('Marcas')
                ->relationship('brand', 'name')
                ->searchable()
                ->preload(),
            SelectFilter::make('Categorías')
                ->relationship('category', 'name')
                ->searchable()
                ->preload(),
            QueryBuilder::make()
                ->constraints([
                    NumberConstraint::make('stock_final')
                        ->label('Stock')
                ]),
        ];
    }

    protected static function groups(): array
    {
        return [
            Group::make('category.name')
                ->label('Categorías')
                ->getDescriptionFromRecordUsing(fn(Product $product): string => $product->category->description)
                ->collapsible(),
            Group::make('brand.name')
                ->label('Marcas')
                ->getDescriptionFromRecordUsing(fn(Product $product): string => $product->brand->description)
                ->collapsible(),
        ];
    }

    protected static function columns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nombre')
                ->description(fn(Product $product): string => strip_tags($product->description), position: 'above')
                ->searchable(),
            MoneyColumn::make('unity_price')
                ->label('Precio unitario'),
            TextColumn::make('category.name')
                ->label('Categoría')
                ->numeric()
                ->sortable(),
            TextColumn::make('brand.name')
                ->label('Marca')
                ->numeric()
                ->sortable(),
            TextColumn::make('stock_final')
                ->label('Stock')
                ->numeric()
                ->sortable()
                ->badge()
                ->color(fn(Product $product, int $state) => self::get_bagdes_color($product, $state)),
            ImageColumn::make('image_url')
                ->label('Imagen')
                ->square(),
        ];
    }

    protected static function actions(): array
    {
        return [
            ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
                Action::make('activities')->url(fn($record) => ProductResource::getUrl('activities', ['record' => $record])),
            ])
        ];
    }

    protected static function get_bagdes_color(Product $product, int $state): string
    {
        return  $state >= $product->stock_min ? 'success' : 'danger';
    }
}
