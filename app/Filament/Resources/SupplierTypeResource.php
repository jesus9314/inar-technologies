<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages\SupplierTypeActivityLogPage;
use App\Filament\Resources\SupplierTypeResource\Pages;
use App\Models\SupplierType;
use App\Traits\Forms\SupplierTraitForms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierTypeResource extends Resource
{
    use SupplierTraitForms;

    protected static ?string $model = SupplierType::class;

    protected static ?string $navigationIcon = 'heroicon-c-hashtag';

    protected static ?string $navigationGroup = 'Proveedores';

    protected static ?string $modelLabel = 'Tipo de Proveedor';

    protected static ?string $pluralModelLabel = 'Tipo de proveedores';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::supplier_type_form());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
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
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('activities')->url(fn ($record) => SupplierTypeResource::getUrl('activities', ['record' => $record])),
                ])
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
            'index' => Pages\ManageSupplierTypes::route('/'),
            'activities' => SupplierTypeActivityLogPage::route('/{record}/activities'),
        ];
    }
}
