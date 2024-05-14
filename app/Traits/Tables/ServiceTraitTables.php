<?php

namespace App\Traits\Tables;

use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

trait ServiceTraitTables
{
    protected static function service_table(Table $form): Table
    {
        return $form
            // ->groups(self::groups())
            ->extremePaginationLinks()
            ->striped()
            ->columns(self::columns())
            ->filters(self::filters())
            ->actions(self::actions())
            ->bulkActions(self::bulkActions());
    }

    protected static function groups(): array
    {
        return [
            Group::make('category.name')
                ->label('Categoría'),
        ];
    }

    protected static function columns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nombre')
                ->searchable(),
            TextColumn::make('description')
                ->label('Descripción')
                ->searchable(),
            TextColumn::make('category.name')
                ->label('Categoría')
                ->searchable(),
            // MoneyColumn::make('product.unity_price')
            //     ->label('Precio')
            //     ->currency('PEN')
            //     ->searchable(),
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

    protected static function filters(): array
    {
        return [
            //
        ];
    }

    protected static function actions(): array
    {
        return [
            ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
            ])
        ];
    }

    protected static function bulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }
}
