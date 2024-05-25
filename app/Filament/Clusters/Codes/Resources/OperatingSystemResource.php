<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\OperatingSystemResource\Pages;
use App\Filament\Clusters\Codes\Resources\OperatingSystemResource\Pages\OperatingSystemActivityLogPage;
use App\Filament\Clusters\Codes\Resources\OperatingSystemResource\RelationManagers;
use App\Models\OperatingSystem;
use App\Traits\Forms\DevicesTraitForms;
use App\Traits\Tables\DeviceTraitTables;
use App\Traits\TraitForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OperatingSystemResource extends Resource
{
    use DevicesTraitForms, DeviceTraitTables;

    protected static ?string $model = OperatingSystem::class;

    protected static ?string $navigationIcon = 'heroicon-s-eye';

    protected static ?string $navigationGroup = 'Dispositivos';

    protected static ?string $modelLabel = 'sistema operativo';

    protected static ?string $pluralModelLabel = 'sistemas operativos';

    protected static ?string $cluster = Codes::class;

    public static function form(Form $form): Form
    {
        return self::operating_system_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::operating_system_table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageOperatingSystems::route('/'),
            'activities' => OperatingSystemActivityLogPage::route('/{record}/activities'),
        ];
    }
}
