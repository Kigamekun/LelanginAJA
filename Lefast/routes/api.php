<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/register', [ApiController::class, 'register']);
//API route for login user
Route::post('/login', [ApiController::class, 'login']);

Route::get('/banner', [ApiController::class, 'banner'])->name('api.banner');
// Route::get('/pay/{id}', [ApiController::class, 'pay'])->name('api.pay');
// Route::get('/pay-finish', [ApiController::class, 'payFinish'])->name('api.pay-finish');
//Protecting Routes

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/product', [ApiController::class, 'product'])->name('api.product');
    Route::get('/history', [ApiController::class, 'history'])->name('api.history');
    Route::post('/bid/{id}', [ApiController::class, 'bid'])->name('api.bid');
    Route::get('/bidder', [ApiController::class, 'bidder'])->name('api.bidder');
    Route::post('/edit', [ApiController::class, 'edit'])->name('api.edit');
    Route::post('/cancel-bid', [ApiController::class, 'cancelBid'])->name('api.cancel-bid');

    // API route for logout user
    Route::post('/logout', [ApiController::class, 'logout']);
});
