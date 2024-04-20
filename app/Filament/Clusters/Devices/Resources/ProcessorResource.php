<?php

namespace App\Filament\Clusters\Devices\Resources;

use App\Filament\Clusters\Devices;
use App\Filament\Clusters\Devices\Resources\ProcessorResource\Pages;
use App\Filament\Clusters\Devices\Resources\ProcessorResource\RelationManagers;
use App\Models\Processor;
use App\Traits\TraitForms;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProcessorResource extends Resource
{
    use TraitForms;

    protected static ?string $model = Processor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Devices::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('model')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('generation')
                    ->maxLength(255),
                Forms\Components\TextInput::make('cores')
                    ->maxLength(255),
                Forms\Components\TextInput::make('socket')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tdp')
                    ->maxLength(255),
                Forms\Components\TextInput::make('integrated_graphics')
                    ->maxLength(255),
                Select::make('memory_type_id')
                    ->relationship('memoryType', 'description')
                    ->createOptionForm(self::just_description())
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('memory_capacity')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description'),
                Forms\Components\FileUpload::make('image_url')
                    ->image(),
                Forms\Components\TextInput::make('specifications_url')
                    ->suffixIcon('heroicon-m-globe-alt')
                    ->url(),
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(self::brand_form())
                    ->required(),
                Forms\Components\Select::make('processor_condition_id')
                    ->relationship('processorCondition', 'description')
                    ->createOptionForm(self::just_description())
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('generation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cores')
                    ->searchable(),
                Tables\Columns\TextColumn::make('socket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tdp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('integrated_graphics')
                    ->searchable(),
                Tables\Columns\TextColumn::make('memory_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('memory_capacity')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_url'),
                Tables\Columns\TextColumn::make('specifications_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('processor_condition_id')
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
            'index' => Pages\ListProcessors::route('/'),
            'create' => Pages\CreateProcessor::route('/create'),
            'view' => Pages\ViewProcessor::route('/{record}'),
            'edit' => Pages\EditProcessor::route('/{record}/edit'),
        ];
    }
}
