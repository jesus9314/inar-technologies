<?php

namespace App\Traits\Tables;

use App\Filament\Resources\BrandResource;
use App\Filament\Resources\CategoryResource;
use Filament\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

trait TraitTables
{
    /**
     * AffectationResource
     */
    protected static function affectation_table(Table $table): Table
    {
        return $table
            ->striped()
            ->extremePaginationLinks()
            ->columns(self::affectation_columns())
            ->filters(self::affectation_filters())
            ->actions(self::affectation_actions())
            ->bulkActions(self::affectation_bulkActions());
    }

    protected static function affectation_columns(): array
    {
        return [
            TextColumn::make('code')
                ->searchable(),
            TextColumn::make('description')
                ->searchable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    protected static function affectation_filters(): array
    {
        return [
            //
        ];
    }

    protected static function affectation_actions(): array
    {
        return [
            ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
        ];
    }
    protected static function affectation_bulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }

    /**
     * BrandResource
     */
    protected static function brand_table(Table $table): Table
    {
        return $table
            ->striped()
            ->extremePaginationLinks()
            ->columns(self::brand_columns())
            ->filters(self::brand_filters())
            ->actions(self::brand_actions())
            ->bulkActions(self::brand_bulkActions());
    }

    protected static function brand_columns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nombre')
                ->searchable(),
            ImageColumn::make('image_url')
                ->square()
                ->label('Imagen'),
        ];
    }

    protected static function brand_filters(): array
    {
        return [
            //
        ];
    }

    protected static function brand_actions(): array
    {
        return [
            ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                Action::make('activities')
                    ->url(fn ($record) => BrandResource::getUrl('activities', ['record' => $record]))
                    ->icon('heroicon-c-bell-alert'),
                DeleteAction::make(),
            ])
        ];
    }

    protected static function brand_bulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }

    /**
     * CategoryResource
     */
    protected static function category_table(Table $table): Table
    {
        return $table
            ->striped()
            ->extremePaginationLinks()
            ->columns(self::category_columns())
            ->filters(self::category_filters())
            ->actions(self::category_actions())
            ->bulkActions(self::category_bulkActions());
    }

    protected static function category_columns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nombre')
                ->searchable(),
            TextColumn::make('slug')
                ->searchable(),
            ImageColumn::make('image_url')
                ->label('Imagen'),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    protected static function category_filters(): array
    {
        return [
            //
        ];
    }

    protected static function category_actions(): array
    {
        return [
            ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('activities')
                    ->url(fn ($record) => CategoryResource::getUrl('activities', ['record' => $record]))
                    ->icon('heroicon-c-bell-alert'),
            ])
        ];
    }

    protected static function category_bulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }
}
