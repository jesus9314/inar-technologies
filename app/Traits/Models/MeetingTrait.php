<?php

namespace App\Traits\Models;

use Carbon\Carbon;

trait MeetingTrait
{
    protected static function getBorderClass(string $date): string
    {
        $date = Carbon::parse($date);
        if ($date->isPast()) {
            // Si la fecha ya ha pasado, retornar color rojo claro
            return "border-l-danger-500"; // Color rojo claro
        } else {
            // Si la fecha no ha pasado, retornar color celeste
            return "border-l-primary-500"; // Color celeste
        }
    }

    protected static function getHourColor(string $date): string
    {

        $date = Carbon::parse($date);
        if ($date->isPast()) {
            // Si la fecha ya ha pasado, retornar color rojo claro
            return "text-danger-500"; // Color rojo claro
        } else {
            // Si la fecha no ha pasado, retornar color celeste
            return "text-primary-500"; // Color celeste
        }
    }

    protected static function getBgColorByDate(string $date): string
    {
        // Crear una instancia de Carbon a partir de la fecha en string
        $fecha = Carbon::parse($date);

        // Comparar la fecha actual con la fecha proporcionada
        if ($fecha->isPast()) {
            // Si la fecha ya ha pasado, retornar color rojo claro
            return '#FFCCCC'; // Color rojo claro
        } else {
            // Si la fecha no ha pasado, retornar color celeste
            return '#ADD8E6'; // Color celeste
        }
    }

    protected static function getHourFormat(String $date): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('g:i A');
    }
}
