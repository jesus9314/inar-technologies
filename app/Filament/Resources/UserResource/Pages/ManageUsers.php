<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Usuarios' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('customer_id', null)),
            'Clientes' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('customer_id', '!=', null)),
            'Todos' => Tab::make()
            // 'Todos' => Tab::make()
            //     ->modifyQueryUsing(fn (Builder $query) => $query->where('customer_id', '!=', null)),
        ];
    }
}
