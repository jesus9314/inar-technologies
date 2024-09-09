<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentTypes\Models\Type;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;


    protected static string $view = 'filament-invoices::pages.view-invoice';


    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->icon('heroicon-o-pencil'),
            Actions\DeleteAction::make()->icon('heroicon-o-trash'),
            Actions\Action::make('print')
                ->label(trans('filament-invoices::messages.invoices.actions.print'))
                ->icon('heroicon-o-printer')
                ->color('info')
                ->action(function (){
                    $this->js('window.print()');
                }),
        ];
    }
}
