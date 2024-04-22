<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\ActivityUserLogPage;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Manejo de Usuarios';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Usuario';

    protected static ?string $pluralModelLabel = 'Usuarios';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        $AuthUser = User::find(auth()->user()->id);

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name_m')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name_p')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('dni')
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Get $get, Set $set, $state) => self::set_person_data($get, $set, $state))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ruc')
                    ->required()
                    ->maxLength(255),
                Select::make('id_document_id')
                    ->relationship('idDocument', 'description')
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->disabledOn('edit')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->hiddenOn(['edit', 'view'])
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('theme')
                    ->hiddenOn('create')
                    ->maxLength(255)
                    ->default('default'),
                ColorPicker::make('theme_color')
                    ->hiddenOn('create')
                    ->rgb(),
                Select::make('roles')
                    ->visible($AuthUser->can('activities_brand'))
                    ->multiple()
                    ->preload()
                    ->relationship('roles', 'name'),
                FileUpload::make('avatar_url')
                    ->avatar()
                    ->imageEditor()
                    ->directory('avatars')
                    ->optimize('webp')
                    ->resize(50),
            ]);
    }

    public static function set_person_data(Get $get, Set $set, $state)
    {
        $data = getDataFromDni($state);
        $set('name', $data->nombres);
        $set('last_name_m', $data->apellidoMaterno);
        $set('last_name_p', $data->apellidoPaterno);
        $set('id_document_id', 2);
    }

    public function isSuperAdmin($record): bool
    {
        $user = User::find($record->id);
        return $user->hasRole('super_admin');
    }

    public static function table(Table $table): Table
    {
        $AuthUser = User::find(auth()->user()->id);

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Verificado')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('avatar_url')
                    ->defaultImageUrl(fn ($record): string => 'https://ui-avatars.com/api/?background=000000&color=FFFFFF&name=' . $record->name)
                    ->label('Foto')
                    ->circular(),
                Tables\Columns\TextColumn::make('theme')
                    ->searchable(),
                ColorColumn::make('theme_color')
                    ->label('Color')
                    ->copyable()
                    ->copyMessage('Código del color copiado')
                    ->copyMessageDuration(1500)
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label('Rol')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'panel_user' => 'danger',
                        'supervisor' => 'danger',
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('activities')
                        ->url(fn ($record) => UserResource::getUrl('activities', ['record' => $record]))
                        ->icon('heroicon-c-bell-alert'),
                    Tables\Actions\DeleteAction::make()
                        ->hidden(function ($record) {
                            $user = User::find($record->id);
                            return $user->hasRole('super_admin');
                        }),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn (Model $record): bool => !$record->hasRole('super_admin'),
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
            'activities' => ActivityUserLogPage::route('/{record}/activities'),
        ];
    }
}
