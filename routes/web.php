<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnidadController;

use App\Http\Controllers\FileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PiezasController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\VentasController;
use Gloudemans\Shoppingcart\Facades\Cart;

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

Route::redirect('/', 'login');

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('unidad', [UnidadController::class, 'index'])->name('unidad.index');
Route::get('unidad/{id}/ver', [UnidadController::class, 'show'])->name('unidad.show');

Route::get('/dashboard', function () {
    //Creating the store instance
    $user = Auth::user();
    Cart::instance('yonkeecoverde')->restore($user->id);

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*Route::get('/new', function () {
    return view('car-new');
})->middleware(['auth', 'verified'])->name('new');*/

//Route::get('images/{id}/{autos}',[FileController::class, 'getImages'])->name('getImages');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Unidades
    Route::get('/new', function () {
        return view('car-new');
    })->name('new');
    Route::post('/savenewcar', [UnidadController::class, 'saveUnit'])->name('unidad.saveUnit');
    Route::post('/updatecar', [UnidadController::class, 'saveUnit'])->name('unidad.saveUnit');
    Route::post('upload-media', FileController::class)->name('upload-media');
    //Route::get('images/{id}',[FileController::class, 'getImages'])->name('getImages');
    Route::delete('/delete-image/{id}', [FileController::class, 'destroy'])->name('delete.image');
    Route::get('/get-car-data', [StockController::class, 'getCarData'])->name('get-car-data');
    Route::get('/get-stock-data', [StockController::class, 'getStockData'])->name('get-stock-data');

    // Inventario
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::get('/stock/{id}/ver', [StockController::class, 'show'])->name('stock.show');
    Route::get('/stock-nuevo', [StockController::class, 'new'])->name('stock.new');
    /*Route::get('/stock-nuevo', function () {
        return view('stock-new');
    })->name('stock.new');*/
    Route::post('/savenewstock', [StockController::class, 'saveUnit'])->name('stock.saveUnit');

    // Piezas
    Route::get('/piezas', [PiezasController::class, 'index'])->name('piezas.index');
    Route::get('/piezas/{id}/ver', [PiezasController::class, 'show'])->name('piezas.show');
    Route::get('/nueva-pieza', function () {
        return view('piezas-new');
    })->name('newpiece');
    Route::post('/savePiece', [PiezasController::class, 'savePiece'])->name('piezas.savePiece');

    // Usuarios
    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/{id}/ver', [UsuariosController::class, 'show'])->name('usuarios.show');
    Route::get('/usuario-nuevo', function () {
        return view('usuarios-new');
    })->name('newuser');
    Route::post('/saveUser', [UsuariosController::class, 'saveUser'])->name('usuarios.saveUser');

    // Ventas
    Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');
    Route::get('/venta-nueva', [VentasController::class, 'new'])->name('ventas.new');
    Route::get('/search', [StockController::class, 'search'])->name('stock.search');
    Route::post('/add-item-to-sale', [VentasController::class, 'addItemToSale'])->name('ventas.addItemToSale');
    Route::get('/get-sub-total', [VentasController::class, 'getSubTotal'])->name('ventas.getSubTotal');
    Route::get('/delete-article', [VentasController::class, 'deleteArticle'])->name('ventas.deleteArticle');
    Route::get('/ver-inventario', [VentasController::class, 'seeCart'])->name('ventas.seeCart');
    Route::post('/registerSale', [VentasController::class, 'registerSale'])->name('ventas.registerSale');
    Route::get('/recibo/{id}/ver', [VentasController::class, 'showReceipt'])->name('ventas.showReceipt');

    // Miscellaneous
    Route::get('/generate-password', [UsuariosController::class, 'saveGeneratePassword'])->name('generate.password');

});

require __DIR__.'/auth.php';
