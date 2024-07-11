<?php

use App\Http\Controllers\System\CategoryController;
use App\Http\Controllers\System\ProductController;
use App\Http\Controllers\System\ReportController;
use App\Http\Controllers\System\HomeController;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\System\SaleController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    #Routes home
        Route::controller(HomeController::class)
        ->prefix('home')
        ->as('home.')
        ->group(function () {
            
            Route::get('/', 'index')->name('index');
            Route::get('access-denied', 'accessDenied')->name('access-denied');

        }
    );

    Route::group(['middleware' => 'checkUserAccess:1'], function () {
        #Routes users
        Route::controller(UserController::class)
            ->prefix('users')
            ->as('user.')
            ->group(function () {
                
                Route::get('/', 'index')->name('index');

            }
        );
    });

    Route::group(['middleware' => 'checkUserAccess:1,3'], function () {
        #Routes categories
        Route::controller(CategoryController::class)
            ->prefix('categories')
            ->as('category.')
            ->group(function () {
                
                Route::get('/', 'index')->name('index');

            }
        );

        #Routes products
        Route::controller(ProductController::class)
            ->prefix('products')
            ->as('product.')
            ->group(function () {
                
                Route::get('/', 'index')->name('index');

            }
        );
    });

    Route::group(['middleware' => 'checkUserAccess:1,4'], function () {
        #Routes sales
        Route::controller(SaleController::class)
            ->prefix('sales')
            ->as('sale.')
            ->group(function () {
                
                Route::get('/', 'index')->name('index');
                Route::get('ticket/{id}', 'ticket')->name('ticket');

            }
        );
    });

    Route::group(['middleware' => 'checkUserAccess:1,2'], function () {
        #Routes reports
        Route::controller(ReportController::class)
            ->prefix('reports')
            ->as('report.')
            ->group(function () {
                
                Route::get('/', 'index')->name('index');

            }
        );
    });
    

});
