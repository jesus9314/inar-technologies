<?php

namespace App\Http\Controllers;

use App\Models\Api;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\Purchase;
use App\Models\Unit;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
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
        return ProductPurchase::where('purchase_id', 1)->get();
    }
}
