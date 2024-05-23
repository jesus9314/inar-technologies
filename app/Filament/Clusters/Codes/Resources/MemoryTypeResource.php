<?php

namespace App\Filament\Clusters\Codes\Resources;

use App\Filament\Clusters\Codes;
use App\Filament\Clusters\Codes\Resources\MemoryTypeResource\Pages;
use App\Filament\Clusters\Codes\Resources\MemoryTypeResource\Pages\MemoryTypeActivityLogPage;
use App\Filament\Clusters\Codes\Resources\MemoryTypeResource\RelationManagers;
use App\Models\MemoryType;
use App\Traits\Tables\TraitTables;
use App\Traits\Forms\TraitForms;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemoryTypeResource extends Resource
{
    use TraitForms, TraitTables;

    protected static ?string $model = MemoryType::class;

    protected static ?string $navigationIcon = 'heroicon-m-credit-card';

    protected static ?string $navigationLabel = 'Tipo de Memorias';

    protected static ?string $modelLabel = 'Tipo de Memorias';

    protected static ?string $pluralModelLabel = 'Tipos de Memorias';

    protected static ?string $cluster = Codes::class;

    public static function form(Form $form): Form
    {
        return self::memory_type_form($form);
    }

    public static function table(Table $table): Table
    {
        return self::memory_type_table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMemoryTypes::route('/'),
            'activities' => MemoryTypeActivityLogPage::route('/{record}/activities'),
        ];
    }
}
