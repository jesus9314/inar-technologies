<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class CalendarPage extends Page
{
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.calendar-page';

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Mantenimientos';

    protected static ?string $modelLabel = 'Citas';

    protected static ?string $pluralModelLabel = 'Citas';

    protected static ?string $title = 'Registrar Citas';

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\CustomerStats::class,
            // Calendar::class,
        ];
    }
}
