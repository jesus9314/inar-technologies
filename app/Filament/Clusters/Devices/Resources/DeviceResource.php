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
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('aditional_info')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('ram_total')
                    ->required()
                    ->numeric(),
                FileUpload::make('speccy_snapshot_url')
                    ->required()
                    ->columnSpanFull(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->preload()
                    ->searchable(),
                Select::make('device_state_id')
                    ->relationship('deviceState', 'id')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('processor_id')
                    ->relationship('processor', 'model')
                    ->searchable()
                    ->preload()
                    ->required(),
                Repeater::make('deviceOperatingSystems')
                    ->relationship()
                    ->label('Sistemas Operativos')
                    ->schema([
                        Select::make('operating_system_id')
                            ->relationship('operatingSystem', 'description')
                            ->createOptionForm(self::operating_system_form())
                            ->preload()
                            ->searchable()
                            ->required()
                    ]),
                Repeater::make('deviceGraphics')
                    ->label('Tarjetas Gráficas')
                    ->relationship()
                    ->schema([
                        Select::make('graphic_id')
                            ->relationship('graphic', 'model')
                            ->createOptionForm(self::graphics_form())
                            ->preload()
                            ->searchable()
                            ->required()
                    ]),
                Repeater::make('devicePeripherals')
                    ->label('Periféricos')
                    ->relationship()
                    ->schema([
                        Select::make('peripheral_id')
                            ->relationship('peripheral', 'description')
                            ->createOptionForm(self::peripheral_form())
                            ->preload()
                            ->searchable()
                            ->required()
                    ]),
                Repeater::make('deviceRams')
                    ->label('Memorias Ram')
                    ->relationship()
                    ->schema([
                        Select::make('ram_id')
                            ->relationship('ram', 'id')
                            ->createOptionForm(self::ram_form())
                            ->preload()
                            ->searchable()
                            ->required(),
                        TextInput::make('quantity')
                            ->required()
                            ->integer()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ram_total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deviceState.id')
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
            'index' => Pages\ListDevices::route('/'),
            'create' => Pages\CreateDevice::route('/create'),
            'view' => Pages\ViewDevice::route('/{record}'),
            'edit' => Pages\EditDevice::route('/{record}/edit'),
        ];
    }
}
