<?php

namespace App\Filament\Clusters\Devices\Resources;

use App\Filament\Clusters\Devices;
use App\Filament\Clusters\Devices\Resources\DeviceResource\Pages;
use App\Filament\Clusters\Devices\Resources\DeviceResource\RelationManagers;
use App\Models\Device;
use App\Traits\TraitForms;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeviceResource extends Resource
{
    use TraitForms;

    protected static ?string $model = Device::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Devices::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->hiddenOn('create')
                    ->columnSpanFull(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),
                Select::make('device_type_id')
                    ->relationship('deviceType', 'description')
                    ->searchable()
                    ->preload()
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Textarea::make('aditional_info')
                    ->columnSpanFull(),
                TextInput::make('ram_total')
                    ->numeric(),
                FileUpload::make('speccy_snapshot_url')
                    ->columnSpanFull(),
                Select::make('device_state_id')
                    ->relationship('deviceState', 'id')
                    ->searchable()
                    ->preload(),
                Select::make('processor_id')
                    ->relationship('processor', 'model')
                    ->searchable()
                    ->preload(),
                Repeater::make('deviceOperatingSystems')
                    ->relationship()
                    ->label('Sistemas Operativos')
                    ->schema([
                        Select::make('operating_system_id')
                            ->relationship('operatingSystem', 'description')
                            ->createOptionForm(self::operating_system_form())
                            ->preload()
                            ->searchable()
                    ])
                    ->defaultItems(0),
                Repeater::make('deviceGraphics')
                    ->label('Tarjetas Gráficas')
                    ->relationship()
                    ->schema([
                        Select::make('graphic_id')
                            ->relationship('graphic', 'model')
                            ->createOptionForm(self::graphics_form())
                            ->preload()
                            ->searchable()
                    ])
                    ->defaultItems(0),
                Repeater::make('devicePeripherals')
                    ->label('Periféricos')
                    ->relationship()
                    ->schema([
                        Select::make('peripheral_id')
                            ->relationship('peripheral', 'description')
                            ->createOptionForm(self::peripheral_form())
                            ->preload()
                            ->searchable()
                    ])
                    ->defaultItems(0),
                Repeater::make('deviceRams')
                    ->label('Memorias Ram')
                    ->relationship()
                    ->schema([
                        Select::make('ram_id')
                            ->relationship('ram', 'id')
                            ->createOptionForm(self::ram_form())
                            ->preload()
                            ->searchable(),
                        TextInput::make('quantity')
                            ->integer()
                    ])
                    ->defaultItems(0)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ram_total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deviceState.description')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('processor_id')
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
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                ])
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
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'view' => Pages\ViewDevice::route('/{record}'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }
}
