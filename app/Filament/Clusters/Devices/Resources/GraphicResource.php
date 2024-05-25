<?php

namespace App\Filament\Clusters\Devices\Resources;

use App\Filament\Clusters\Devices;
use App\Filament\Clusters\Devices\Resources\GraphicResource\Pages;
use App\Filament\Clusters\Devices\Resources\GraphicResource\RelationManagers;
use App\Models\Graphic;
use App\Traits\Devices\AditionalForms;
use App\Traits\Forms\DevicesTraitForms;
use App\Traits\TraitForms;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class GraphicResource extends Resource
{
    use DevicesTraitForms;

    protected static ?string $model = Graphic::class;

    protected static ?string $navigationIcon = 'heroicon-c-trophy';

    protected static ?string $navigationGroup = 'Componentes';

    protected static ?string $navigationLabel = 'Tarjetas Gráficas';

    protected static ?string $modelLabel = 'memoria ram';

    protected static ?string $pluralModelLabel = 'memorias Ram';

    protected static ?string $cluster = Devices::class;

    public static function form(Form $form): Form
    {
        return self::graphics_form($form);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('clock')
                    ->searchable(),
                Tables\Columns\TextColumn::make('memory_capacity')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_url'),
                Tables\Columns\TextColumn::make('specifications_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('memoryType.id')
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGraphics::route('/'),
            'create' => Pages\CreateGraphic::route('/create'),
            'view' => Pages\ViewGraphic::route('/{record}'),
            'edit' => Pages\EditGraphic::route('/{record}/edit'),
        ];
    }
}
