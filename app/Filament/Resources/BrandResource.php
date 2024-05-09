<?php

namespace App\Filament\Resources;

use App\Filament\Exports\BrandExporter;
use App\Filament\Imports\BrandImporter;
use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
use App\Models\User;
use App\Traits\Forms\TraitForms;
use App\Traits\Tables\TraitTables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    use TraitForms, TraitTables;

    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationGroup = 'Productos y Servicios';

    protected static ?string $modelLabel = 'Marca';

    protected static ?string $pluralModelLabel = 'Marcas';

    public static function form(Form $form): Form
    {
        return self::brand_form($form);
    }

    public static function table(Table $table): Table
    {
        // $AuthUser = User::find(auth()->user()->id);

        return self::brand_table($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBrands::route('/'),
            'activities' => Pages\ActivityLogBrandPage::route('/{record}/activities'),
        ];
    }
}
