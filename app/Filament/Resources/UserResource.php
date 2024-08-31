<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\ActivityUserLogPage;
use App\Models\User;
use App\Traits\Forms\CommonForms;
use App\Traits\InfoList\UserInfoList;
use App\Traits\Forms\UserForms;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    use CommonForms, UserInfoList;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-m-users';

    protected static ?string $navigationGroup = 'Manejo de Usuarios';

    protected static ?string $modelLabel = 'Usuario';

    protected static ?string $pluralModelLabel = 'Usuarios';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::user_form());
    }

    public function isSuperAdmin($record): bool
    {
        $user = User::find($record->id);
        return $user->hasRole('super_admin');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(self::user_infolist());
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
                    ->defaultImageUrl(fn($record): string => 'https://ui-avatars.com/api/?background=000000&color=FFFFFF&name=' . $record->name)
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
                // ->color(fn (string $state): string => match ($state) {
                //     'super_admin' => 'danger',
                //     'panel_user' => 'danger',
                //     'supervisor' => 'danger',
                // })
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->hidden(
                            fn($record) => !User::find($record->id)->hasRole('super_admin')
                        ),
                    Tables\Actions\Action::make('activities')
                        ->hidden(
                            fn($record) => !User::find(auth()->user()->id)->can('activities_user')
                        )
                        ->url(fn($record) => UserResource::getUrl('activities', ['record' => $record]))
                        ->icon('heroicon-c-bell-alert'),
                    Tables\Actions\DeleteAction::make()
                        ->hidden(
                            fn($record) => $record->id == 1 ? true : false
                        ),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn(Model $record): bool => !$record->hasRole('super_admin'),
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
