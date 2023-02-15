<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CoreController,AdminController,ProductController,AuctionController,BannerController,EventController,HelpCenterController,ApiController,UserController};
use App\Models\{Product,Banner,Event};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $data = Product::limit(6)->orderBy('id','DESC')->get();
    if (isset($_GET['order']) && $_GET['order'] == 2) {
        $data = Product::limit(6)->orderBy('id','DESC')->get();
    } else {
        $data = Product::limit(6)->orderBy('id','ASC')->get();
    }
    $banner = Banner::limit(3)->get();
    $event = Event::limit(10)->get();
    return view('landing-page', ['data'=>$data,'banner'=>$banner,'event'=>$event]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/auth.php';

Route::get('/chat', [CoreController::class, 'chat'])->name('chat');
Route::get('/auction-list', [CoreController::class, 'auctionList'])->name('auction-list');
Route::get('/help-center', [CoreController::class, 'helpCenter'])->name('help-center');
Route::get('/search', [CoreController::class, 'search'])->name('search');
Route::get('/filter', [CoreController::class, 'filter'])->name('filter');
Route::get('/detail/{id}', [CoreController::class, 'detail'])->name('detail');
Route::post('/cst', [CoreController::class,'cst'])->name('cst');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/delete-bookmark', [CoreController::class, 'deleteBookmark'])->name('delete-bookmark');
    Route::post('/add-bookmark', [CoreController::class, 'addBookmark'])->name('add-bookmark');
    Route::get('/bookmarks', [CoreController::class, 'bookmarks'])->name('bookmarks');
    Route::get('/notifications', [CoreController::class, 'notifications'])->name('notifications');
    Route::get('/history', [CoreController::class, 'history'])->name('history');
    Route::post('/set-bid/{product_id}', [CoreController::class, 'setBid'])->name('set-bid');
    Route::post('/cancel-bid/{product_id}', [CoreController::class, 'cancelBid'])->name('cancel-bid');
    Route::get('/get-snap-token/{id}', [CoreController::class,'getSnapToken'])->name('get-snap-token');
});



Route::get('/pay-api/{id}', [ApiController::class, 'pay'])->name('pay-api');
Route::get('/pay-api-finish', [ApiController::class, 'payFinish'])->name('pay-api-finish');

Route::prefix('admin')->name('admin.')->middleware(['auth','checkRole:2,3'])->group(function () {
    Route::get('/', [AdminController::class,'index'])->name('index');


    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class,'index'])->name('product.index');
        Route::get('/create', [ProductController::class,'create'])->name('product.create');
        Route::post('/store', [ProductController::class,'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class,'edit'])->name('product.edit');
        Route::post('/update/{id}', [ProductController::class,'update'])->name('product.update');
        Route::get('/delete/{id}', [ProductController::class,'destroy'])->name('product.delete');
        Route::get('/stop/{id}', [ProductController::class,'stop'])->name('product.stop');
    });

    Route::prefix('banner')->group(function () {
        Route::get('/', [BannerController::class,'index'])->name('banner.index');
        Route::get('/create', [BannerController::class,'create'])->name('banner.create');
        Route::post('/store', [BannerController::class,'store'])->name('banner.store');
        Route::get('/edit/{id}', [BannerController::class,'edit'])->name('banner.edit');
        Route::post('/update/{id}', [BannerController::class,'update'])->name('banner.update');
        Route::get('/delete/{id}', [BannerController::class,'destroy'])->name('banner.delete');
    });

    Route::prefix('event')->group(function () {
        Route::get('/', [EventController::class,'index'])->name('event.index');
        Route::get('/create', [EventController::class,'create'])->name('event.create');
        Route::post('/store', [EventController::class,'store'])->name('event.store');
        Route::get('/edit/{id}', [EventController::class,'edit'])->name('event.edit');
        Route::post('/update/{id}', [EventController::class,'update'])->name('event.update');
        Route::get('/delete/{id}', [EventController::class,'destroy'])->name('event.delete');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class,'index'])->name('user.index');
        Route::get('/create', [UserController::class,'create'])->name('user.create');
        Route::post('/store', [UserController::class,'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class,'edit'])->name('user.edit');
        Route::post('/update/{id}', [UserController::class,'update'])->name('user.update');
        Route::get('/delete/{id}', [UserController::class,'destroy'])->name('user.delete');
    });

    Route::prefix('auction')->group(function () {
        Route::get('/', [AuctionController::class,'index'])->name('auction.index');
        Route::get('/create', [AuctionController::class,'create'])->name('auction.create');
        Route::post('/store', [AuctionController::class,'store'])->name('auction.store');
        Route::get('/edit/{id}', [AuctionController::class,'edit'])->name('auction.edit');
        Route::post('/ship/{id}', [AuctionController::class,'ship'])->name('auction.ship');
        Route::post('/update/{id}', [AuctionController::class,'update'])->name('auction.update');
        Route::get('/delete/{id}', [AuctionController::class,'destroy'])->name('auction.delete');
    });
    Route::prefix('help-center')->group(function () {
        Route::get('/', [HelpCenterController::class,'index'])->name('help-center.index');
        Route::get('/create', [HelpCenterController::class,'create'])->name('help-center.create');
        Route::post('/store', [HelpCenterController::class,'store'])->name('help-center.store');
        Route::get('/edit/{id}', [HelpCenterController::class,'edit'])->name('help-center.edit');
        Route::post('/update/{id}', [HelpCenterController::class,'update'])->name('help-center.update');
        Route::get('/delete/{id}', [HelpCenterController::class,'destroy'])->name('help-center.delete');
    });
});
