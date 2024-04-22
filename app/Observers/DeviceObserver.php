<?php

namespace App\Observers;

use App\Models\Device;
use Illuminate\Support\Str;

class DeviceObserver
{
    /**
     * Handle the Device "created" event.
     */
    public function created(Device $device): void
    {
        //obtener el símbol del dispositivo y poner solo en mayúsculas y filtrar tipo slug
        $deviceDesc = $device->deviceType->symbol;
        $deviceDesc = strtoupper(Str::slug($deviceDesc));

        // Obtener el número de dispositivos del usuario y rellenar con ceros
        $userDeviceCount = Device::where('user_id', $device->user_id)->count();
        $userDeviceCount = str_pad($userDeviceCount, 4, '0', STR_PAD_LEFT);

        // Obtener el total de dispositivos en el modelo y rellenar con ceros
        $totalDeviceCount = Device::all()->count();
        $totalDeviceCount = str_pad($totalDeviceCount, 4, '0', STR_PAD_LEFT);

        //obtener el nombre del dispositivo
        $deviceName = "$deviceDesc-$userDeviceCount-$totalDeviceCount";
        $device->name = $deviceName;
        $device->save();
    }

    /**
     * Handle the Device "updated" event.
     */
    public function updated(Device $device): void
    {
        //
    }

    /**
     * Handle the Device "deleted" event.
     */
    public function deleted(Device $device): void
    {
        //
    }

    /**
     * Handle the Device "restored" event.
     */
    public function restored(Device $device): void
    {
        //
    }

    /**
     * Handle the Device "force deleted" event.
     */
    public function forceDeleted(Device $device): void
    {
        //
    }
}
