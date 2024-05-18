<?php

namespace App\Traits\Tables;

use App\Filament\Clusters\Codes\Resources\CurrencyResource;
use App\Filament\Clusters\Codes\Resources\MemoryTypeResource;
use App\Filament\Clusters\Codes\Resources\RamFormFactorResource;
use App\Filament\Clusters\Codes\Resources\UnitResource;
use App\Filament\Clusters\Codes\Resources\WarehouseResource;
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
    //Desde aquí ahorramos tiempo haciendolo en un solo método

    /**
     * RamFormFactorResource
     */
    protected static function ram_form_factor_table(Table $table): Table
    {
        return $table
            ->columns([
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
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    Action::make('activities')
                    ->url(fn ($record) => RamFormFactorResource::getUrl('activities', ['record' => $record]))
                    ->icon('heroicon-c-bell-alert'),
                ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * MemoryTypeResource
     */
    protected static function memory_type_table(Table $table): Table
    {
        return $table
            ->columns([
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
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    Action::make('activities')
                        ->url(fn ($record) => MemoryTypeResource::getUrl('activities', ['record' => $record]))
                        ->icon('heroicon-c-bell-alert'),
                ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    //Aqui todo es como debería
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

    /**
     * CurrencyResource
     */
    protected static function currency_table(Table $table): Table
    {
        return $table
            ->striped()
            ->extremePaginationLinks()
            ->columns(self::currency_columns())
            ->filters(self::currency_filters())
            ->actions(self::currency_actions())
            ->bulkActions(self::currency_bulkActions());
    }

    protected static function currency_columns(): array
    {
        return [
            TextColumn::make('code')
                ->label('Código')
                ->searchable(),
            TextColumn::make('symbol')
                ->label('Símbolo')
                ->searchable(),
            TextColumn::make('description')
                ->label('Descripción')
                ->searchable(),
            TextColumn::make('activityState.description')
                ->label('Estado')
                ->numeric()
                ->sortable(),
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

    protected static function currency_filters(): array
    {
        return [
            //
        ];
    }

    protected static function currency_actions(): array
    {
        return [
            ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('activities')
                    ->url(fn ($record) => CurrencyResource::getUrl('activities', ['record' => $record]))
                    ->icon('heroicon-c-bell-alert'),

            ])
        ];
    }

    protected static function currency_bulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }

    /**
     * UnitResource
     */
    protected static function unit_table(Table $table): Table
    {
        return $table
            ->striped()
            ->extremePaginationLinks()
            ->columns(self::unit_columns())
            ->filters(self::unit_filters())
            ->actions(self::unit_actions())
            ->bulkActions(self::unit_bulkActions());
    }

    protected static function unit_columns(): array
    {
        return [
            TextColumn::make('code')
                ->searchable(),
            TextColumn::make('description')
                ->searchable(),
            TextColumn::make('symbol')
                ->searchable(),
            TextColumn::make('activityState.id')
                ->numeric()
                ->sortable(),
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

    protected static function unit_filters(): array
    {
        return [
            //
        ];
    }

    protected static function unit_actions(): array
    {
        return [
            ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('activities')
                    ->url(fn ($record) => UnitResource::getUrl('activities', ['record' => $record]))
                    ->icon('heroicon-c-bell-alert'),

            ])
        ];
    }

    protected static function unit_bulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }

    /**
     * WarehouseResource
     */
    protected static function warehouse_table(Table $table): Table
    {
        return $table
            ->striped()
            ->extremePaginationLinks()
            ->columns(self::warehouse_columns())
            ->filters(self::warehouse_filters())
            ->actions(self::warehouse_actions())
            ->bulkActions(self::warehouse_bulkActions());
    }

    protected static function warehouse_columns(): array
    {
        return [
            TextColumn::make('description')
                ->label('Descripción')
                ->searchable(),
            TextColumn::make('stablishment')
                ->label('Establecimiento')
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

    protected static function warehouse_filters(): array
    {
        return [
            //
        ];
    }

    protected static function warehouse_actions(): array
    {
        return [
            ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('activities')
                    ->url(fn ($record) => WarehouseResource::getUrl('activities', ['record' => $record]))
                    ->icon('heroicon-c-bell-alert'),

            ])
        ];
    }

    protected static function warehouse_bulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }

    /**
     * IssuePriorityResource
     */
    protected static function issue_priority_table(Table $table): Table
    {
        return $table
            ->columns(self::issue_priority_columns())
            ->filters(self::issue_priority_filters())
            ->actions(self::issue_priority_actions())
            ->bulkActions(self::issue_priority_bulkActions());
    }

    protected static function issue_priority_columns(): array
    {
        return [
            TextColumn::make('name')
                ->searchable(),
            TextColumn::make('color')
                ->badge()
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

    protected static function issue_priority_filters(): array
    {
        return [
            //
        ];
    }

    protected static function issue_priority_actions(): array
    {
        return [
            ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
        ];
    }

    protected static function issue_priority_bulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }
}
