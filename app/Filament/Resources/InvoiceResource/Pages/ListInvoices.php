<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use TomatoPHP\FilamentInvoices\Facades\FilamentInvoices;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use TomatoPHP\FilamentInvoices\Filament\Resources\InvoiceResource\Widgets\InvoiceStatsWidget;
use TomatoPHP\FilamentTypes\Models\Type;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalHeading('Create New Invoice')  // Título del modal
                ->modalWidth('lg'),  // Puedes ajustar el tamaño del modal ('sm', 'lg', 'xl')
            Action::make('test')
        ];
    }


    public function mount(): void
    {
        parent::mount();

        FilamentInvoices::loadTypes();
    }

    protected function getHeaderWidgets(): array
    {
        return [
            InvoiceStatsWidget::class
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('setting')
                ->hiddenLabel()
                ->tooltip(trans('filament-invoices::messages.invoices.actions.invoices_status'))
                ->icon('heroicon-o-cog')
                ->color('info')
                ->action(function (){
                    return redirect()->to(InvoiceStatus::getUrl());
                })
                ->label(trans('filament-invoices::messages.invoices.actions.invoices_status')),
        ];
    }
}
