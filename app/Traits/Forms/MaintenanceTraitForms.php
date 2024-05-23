<?php

namespace App\Traits\Forms;

use App\Traits\Forms\UserForms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;

trait MaintenanceTraitForms
{
    use UserForms;

    private static function maintenance_form(Form $form): Form
    {
        return $form->schema(self::maintenance_schema());
    }

    private static function maintenance_schema(): array
    {
        return [
            DatePicker::make('start_date')
                ->label('Fecha de inicio')
                ->default(now())
                ->native(false)
                ->required(),
            DatePicker::make('end_date')
                ->label('Fecha de finalización')
                ->native(false),
            Select::make('maintenance_state_id')
                ->relationship(
                    name: 'maintenanceState',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn (Builder $query) => $query->where('type', 'maintenance')
                )
                ->searchable()
                ->preload()
                ->native(false)
                ->default(2)
                ->disabled()
                ->dehydrated()
                ->required(),
            Select::make('customer_id')
                ->relationship('customer', 'name')
                ->label('Cliente')
                ->createOptionForm(self::customer_form())
                ->searchable()
                ->preload()
                ->required(),
            Select::make('device_id')
                ->relationship(
                    name: 'device',
                    titleAttribute: 'name',
                )
                ->searchable()
                ->preload()
                ->required(),
            Select::make('user_id')
                ->label('Técnico asignado')
                ->relationship(
                    name: 'user',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn (Builder $query) => $query->whereNot('id', 1)->where('customer_id', null)
                )
                ->createOptionForm(self::user_form())
                ->searchable()
                ->preload()
                ->required(),
            TiptapEditor::make('description')
                ->required()
                ->columnSpanFull(),
        ];
    }
}
