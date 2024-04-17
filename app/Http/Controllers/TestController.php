<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class TestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $units = Unit::all()->except(1);
        $products = Product::where('unit_id', '!=', 1)->get()->toArray();
        $services = Product::where('unit_id', 1)->get()->toArray();
        $allArray = 
        [
            'Productos' => [$products],
            'Servicios' => [$services]
        ];
        return $allArray;
    }
}
