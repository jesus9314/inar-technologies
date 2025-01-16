<?php

namespace App\Observers;

use App\Models\Warehouse;
use Illuminate\Support\Str;

class WarehouseObserver
{
    /**
     * Handle the Warehouse "created" event.
     */
    public function created(Warehouse $warehouse): void
    {
        // Obtener el último código generado (si existe)
        $lastWarehouse = Warehouse::latest()->first();
        $lastCode = $lastWarehouse ? $lastWarehouse->code : '';

        // Extraer el número del último código
        preg_match('/[0-9]+$/', $lastCode, $matches);
        $lastNumber = isset($matches[0]) ? intval($matches[0]) : 0;

        // Generar el nuevo número de código
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Generar el nuevo código completo
        $warehouse->code = strval(Str::slug($warehouse->description) . $newNumber);

        // Guardar los cambios en la base de datos
        $warehouse->save();
    }

    /**
     * Handle the Warehouse "updated" event.
     */
    public function updated(Warehouse $warehouse): void
    {
        //
    }

    /**
     * Handle the Warehouse "deleted" event.
     */
    public function deleted(Warehouse $warehouse): void
    {
        //
    }

    /**
     * Handle the Warehouse "restored" event.
     */
    public function restored(Warehouse $warehouse): void
    {
        //
    }

    /**
     * Handle the Warehouse "force deleted" event.
     */
    public function forceDeleted(Warehouse $warehouse): void
    {
        //
    }
}
