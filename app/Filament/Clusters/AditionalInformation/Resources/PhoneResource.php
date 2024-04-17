<?php

namespace App\Filament\Clusters\AditionalInformation\Resources;

use App\Filament\Clusters\AditionalInformation;
use App\Filament\Clusters\AditionalInformation\Resources\PhoneResource\Pages;
use App\Filament\Clusters\AditionalInformation\Resources\PhoneResource\Pages\ManagePhones;
use App\Filament\Clusters\AditionalInformation\Resources\PhoneResource\RelationManagers;
use App\Models\Phone;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PhoneResource extends Resource
{
    protected static ?string $model = Phone::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    // protected static ?string $navigationGroup = 'Informacón adicional';

    protected static ?string $modelLabel = 'Teléfono';

    protected static ?string $pluralModelLabel = 'Teléfonos';

    protected static ?string $cluster = AditionalInformation::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('number')
                    ->required()
                    ->columnSpan(2)
                    ->maxLength(255),
                Textarea::make('description')
                    ->columnSpan(2)
                    ->columnSpanFull(),
                MorphToSelect::make('phoneable')
                    ->columnSpan(2)
                    ->types([
                        Type::make(Supplier::class)->titleAttribute('name'),
                    ])
                    ->searchable()
                    ->preload()
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->searchable(),
                TextColumn::make('phoneable_type')
                    ->searchable(),
                TextColumn::make('phoneable_id')
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
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePhones::route('/'),
        ];
    }
}
