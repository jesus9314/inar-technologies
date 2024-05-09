<?php

use App\Models\Api;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;

if (!function_exists('getDataFromDni')) {
    function getDataFromDni(String $dni)
    {
        $curl = curl_init();
        $token = config('apis.APIS_NET_PE_KEY');
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $dni,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Referer: https://apis.net.pe/consulta-dni-api',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Datos listos para usar
        $persona = json_decode($response);
        return $persona;
    }
}

if (!function_exists('getDataFromRuc')) {
    function getDataFromRuc($ruc)
    {
        // Iniciar llamada a API
        $curl = curl_init();

        $token = config('apis.APIS_NET_PE_KEY');
        // Buscar ruc sunat
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.apis.net.pe/v2/sunat/ruc?numero=' . $ruc,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Referer: http://apis.net.pe/api-ruc',
                'Authorization: Bearer ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // Datos de empresas según padron reducido
        return $empresa = json_decode($response);
    }
}

/**
 * Retorna si la api especificada en el parámetro está
 * activa o no
 */
if (!function_exists('getApiStatus')) {
    function getApiStatus(Api $api): bool
    {
        return $api->status;
    }
}

/**
 * Retorna el modelo del usuario logeado
 */

if (!function_exists('getUserAuth')) {
    function getUserAuth(): User
    {
        // dd(Auth::user());
        return User::find(auth()->user()->id);
    }
}

