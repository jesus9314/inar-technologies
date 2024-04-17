<?php

namespace App\Filament\Clusters\AditionalInformation\Resources;

use App\Filament\Clusters\AditionalInformation;
use App\Filament\Clusters\AditionalInformation\Resources\EmailResource\Pages;
use App\Filament\Clusters\AditionalInformation\Resources\EmailResource\RelationManagers;
use App\Models\Email;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\MorphToSelect\Type;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmailResource extends Resource
{
    protected static ?string $model = Email::class;

    protected static ?string $navigationIcon = 'heroicon-s-envelope';

    protected static ?string $modelLabel = 'Correo electrónico';

    protected static ?string $pluralModelLabel = 'Correos electrónicos';

    protected static ?string $cluster = AditionalInformation::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->email()
                    ->columnSpan(2)
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->columnSpanFull(),
                MorphToSelect::make('emailable')
                    ->types([
                        Type::make(Supplier::class)->titleAttribute('name'),
                    ])
                    ->columnSpan(2)
                    ->searchable()
                    ->preload()
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('emailable_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('emailable_id')
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManageEmails::route('/'),
        ];
    }
}
