<?php

namespace App\Traits\Tables;

use App\Filament\Clusters\Codes\Resources\OperatingSystemResource;
use App\Filament\Clusters\Devices\Resources\ProcessorResource;
use App\Filament\Clusters\Devices\Resources\RamResource;
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

trait DeviceTraitTables
{
    /**
     * ProcessorResource
     */
    protected static function processor_table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
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
                        ->url(fn ($record) => ProcessorResource::getUrl('activities', ['record' => $record]))
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
     * OperatingSystemResource
     */
    protected static function operating_system_table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label('Nombre')
                    ->searchable(),
                ImageColumn::make('image_url')
                    ->label('Logo'),
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
                        ->url(fn ($record) => OperatingSystemResource::getUrl('activities', ['record' => $record]))
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
     * RamResource
     */
    protected static function ram_table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('latency')
                    ->label('Latencia')
                    ->searchable(),
                ImageColumn::make('image_url')
                    ->label('Imagen'),
                TextColumn::make('specifications_link')
                    ->label('Especificaciones')
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
                        ->url(fn ($record) => RamResource::getUrl('activities', ['record' => $record]))
                        ->icon('heroicon-c-bell-alert'),
                ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
