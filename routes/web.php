<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/auth');
});

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/test', TestController::class);
