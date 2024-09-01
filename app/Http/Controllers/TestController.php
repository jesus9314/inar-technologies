<?php

namespace App\Http\Controllers;

use App\Models\Api;
use App\Models\Customer;
use App\Models\CustomerLog;
use App\Models\Meeting;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\Purchase;
use App\Models\Service;
use App\Models\Unit;
use App\Models\User;
use App\Services\DateService;
use Carbon\Carbon;
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

        // return (new DateService())->getAvailableTimesForDate('2024-08-19');
        // return Auth::user()->id;
        // return Meeting::whereDate('starts_at', '2024-08-19')
        //     ->pluck('starts_at')
        //     ->toArray();
        // return App\Models\CustomerLog::all();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // Consulta la cantidad total de clientes registrados en el mes pasado
        $newCustomers = Customer::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();

        return $newCustomers;

        // return (CustomerLog::where('date', '>=', now()->subDays(30))
        //     ->orderBy('date')
        //     ->pluck('count', 'date')
        //     ->toArray());
    }
}
