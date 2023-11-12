<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// 制限：ログインしているユーザー
Route::group(['middleware' => 'auth'],function(){
    // HOME画面表示
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // itemsから始まるURLのグループ【商品】
    Route::prefix('items')->group(function () {
        // 一覧画面表示
        Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('items.index');
        //詳細画面表示
        Route::get('/detail/{id}', [App\Http\Controllers\ItemController::class, 'showDetail']);
    });
    // salesから始まるURLのグループ【商品】
    Route::prefix('sales')->group(function () {
        //一覧画面表示
        Route::get('/', [App\Http\Controllers\SaleController::class, 'index'])->name('sales.index');
        //検索画面表示
        Route::get('/search', [App\Http\Controllers\SaleController::class, 'showSearch'])->name('sales.search');
        //検索結果画面表示
        Route::get('/add', [App\Http\Controllers\SaleController::class, 'searchResult']);
        //登録画面表示
        Route::get('/count/{id}', [App\Http\Controllers\SaleController::class, 'create']);
        //登録処理実行
        Route::post('/count/{id}', [App\Http\Controllers\SaleController::class, 'store']);
        //詳細画面表示
        Route::get('/detail/{id}', [App\Http\Controllers\SaleController::class, 'detail']);
        //編集画面表示
        Route::get('/edit/{id}', [App\Http\Controllers\SaleController::class, 'edit']);
        //編集処理実行
        Route::post('/edit/{id}', [App\Http\Controllers\SaleController::class, 'update']);
        //編集処理実行
        Route::post('/delete/{id}', [App\Http\Controllers\SaleController::class, 'destroy']);
        // 複製画面表示
        Route::get('/clone/{id}', [App\Http\Controllers\SaleController::class, 'clone']);
        // 複製登録処理実行
        Route::post('/clone/{id}', [App\Http\Controllers\SaleController::class, 'cloneCreate']);
        //ランキングページ表示
        Route::get('/rank', [App\Http\Controllers\SaleController::class, 'rank']);
    });
});

// 制限：ログインしている管理者のみ
Route::group(['middleware' => ['auth','can:管理者']],function(){  
    // itemsから始まるURLのグループ【商品】
    Route::prefix('items')->group(function () {
            // 登録画面表示
            Route::get('/add', [App\Http\Controllers\ItemController::class, 'create']);
            // 登録処理実行
            Route::post('/add', [App\Http\Controllers\ItemController::class, 'store']);
            // 編集画面表示
            Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('items.edit');
            // 情報更新処理実行
            Route::post('/edit/{id}', [App\Http\Controllers\ItemController::class, 'update']);
            // 削除処理実行
            Route::post('/delete/{id}', [App\Http\Controllers\ItemController::class, 'destroy']);
            // 複製画面表示
            Route::get('/clone/{id}', [App\Http\Controllers\ItemController::class, 'clone']);
            // 複製登録処理実行
            Route::post('/clone/{id}', [App\Http\Controllers\ItemController::class, 'cloneCreate']);
    });  
    // usersから始まるURLのグループ【ユーザー】
    Route::prefix('users')->group(function () {
        // 一覧画面表示
        Route::get('/', [App\Http\Controllers\UserController::class, 'userIndex']);
        // 編集画面表示
        Route::get('/edit/{id}', [App\Http\Controllers\UserController::class, 'userShowEdit']);
        // 編集処理実行
        Route::post('/edit/{id}', [App\Http\Controllers\UserController::class, 'userUpdate']);
        // 削除処理実行
        Route::post('/delete/{id}', [App\Http\Controllers\UserController::class, 'userDestroy']);
    });
    // costsから始まるURLのグループ【仕入価格】
    Route::prefix('costs')->group(function () {
        // 一覧画面表示
        Route::get('/', [App\Http\Controllers\CostController::class, 'costIndex'])->name('costs.costIndex');
        // 一覧画面表示(原価率 高い順)
        Route::get('/ratedesc', [App\Http\Controllers\CostController::class, 'costRateDesc'])->name('costs.costRateDesc');
        // 一覧画面表示(原価率 低い順)
        Route::get('/rateasc', [App\Http\Controllers\CostController::class, 'costRateAsc'])->name('costs.costRateAsc');
        // 詳細画面表示
        Route::get('/detail/{id} ', [App\Http\Controllers\CostController::class, 'showDtail'])->name('costs.showDtail');
        // 編集画面表示
        Route::get('/edit/{id}', [App\Http\Controllers\CostController::class, 'costEdit'])->name('costs.costEdit');
        // 編集処理実行
        Route::post('/edit/{id}', [App\Http\Controllers\CostController::class, 'costUpdate'])->name('costs.costUpdate');
        // 削除処理実行
        Route::post('/delete/{id}', [App\Http\Controllers\CostController::class, 'costDestroy']);
    });
    // purchasesから始まるURLのグループ
    Route::prefix('purchases')->group(function () {
        //　検索画面表示
        Route::get('/', [App\Http\Controllers\PurchaseController::class, 'index'])->name('purchases.index');
        //　検索画面表示
        Route::get('/search', [App\Http\Controllers\PurchaseController::class, 'showSearch'])->name('purchases.search');
        //　検索結果画面表示
        Route::get('/add', [App\Http\Controllers\PurchaseController::class, 'searchResult']);
        //　登録画面表示
        Route::get('/count/{id}', [App\Http\Controllers\PurchaseController::class, 'create']);
        //　登録処理実行
        Route::post('/count/{id}', [App\Http\Controllers\PurchaseController::class, 'store']);
        //　詳細画面表示
        Route::get('/detail/{id}', [App\Http\Controllers\PurchaseController::class, 'detail']);
        //　編集画面表示
        Route::get('/edit/{id}', [App\Http\Controllers\PurchaseController::class, 'edit']);
        //　編集処理実行
        Route::post('/edit/{id}', [App\Http\Controllers\PurchaseController::class, 'update']);
        // 複製画面表示
        Route::get('/clone/{id}', [App\Http\Controllers\PurchaseController::class, 'clone']);
        // 複製登録処理実行
        Route::post('/clone/{id}', [App\Http\Controllers\PurchaseController::class, 'cloneCreate']);
        //　削除処理実行
        Route::post('/delete/{id}', [App\Http\Controllers\PurchaseController::class, 'destroy']);
    });
    // categories/typeから始まるURLのグループ
    Route::prefix('categories/type')->group(function () {
        // 一覧画面表示
        Route::get('/', [App\Http\Controllers\TypeController::class, 'typeIndex'])->name('categories.typeIndex');
        // 登録画面表示
        Route::get('/add', [App\Http\Controllers\TypeController::class, 'showTypeAdd'])->name('categories.typeShowAdd');
        // 登録処理実行
        Route::post('/add', [App\Http\Controllers\TypeController::class, 'typeAdd'])->name('categories.typeAdd');
        // 編集画面表示
        Route::get('/edit/{id}', [App\Http\Controllers\TypeController::class, 'showTypeEdit'])->name('categories.typeEdit');
        // 編集処理実行
        Route::post('/edit/{id}', [App\Http\Controllers\TypeController::class, 'typeUpdate'])->name('categories.typeUpdate');
        // 削除処理実行
        Route::post('/delete/{id}', [App\Http\Controllers\TypeController::class, 'typeDestroy']);
    });
    // categories/supplierから始まるURLのグループ
    Route::prefix('categories/supplier')->group(function () {
        // 一覧画面表示
        Route::get('/', [App\Http\Controllers\SupplierController::class, 'supplierIndex'])->name('categories.supplierIndex');
        // 登録画面表示
        Route::get('/add', [App\Http\Controllers\SupplierController::class, 'showSupplierAdd']);
        // 登録処理実行
        Route::post('/add', [App\Http\Controllers\SupplierController::class, 'supplierAdd']);
        // 編集画面表示
        Route::get('/edit/{id}', [App\Http\Controllers\SupplierController::class, 'showSupplierEdit']);
        // 編集処理実行
        Route::post('/edit/{id}', [App\Http\Controllers\SupplierController::class, 'supplierUpdate']);
        // 削除処理実行
        Route::post('/delete/{id}', [App\Http\Controllers\SupplierController::class, 'supplierDestroy']);
    });
});
