<?php

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/categorias', 'HomeController@categorias')->name('categorias');

Route::get('/checkout', 'HomeController@checkout')->name('checkout')->middleware('auth');
Route::get('/categorias/productos', 'HomeController@getProductos')->name('categorias.productos');

Route::get('/product/{slug}', 'HomeController@product')->name('producto.show');

Route::get('/cuenta', 'AccountController@index')->name('mi.cuenta');
Route::put('/update', 'AccountController@update')->name('cuenta.update');


Route::group(['prefix' => '/pedidos'], function () {

Route::get('/', 'OrdersController@index')->name('mis.pedidos');
Route::get('/clientes', 'OrdersController@listarPedidos')->name('pedidos.clientes');
Route::get('/pedido/{id}', 'OrdersController@mostrarPedido')->name('mostrar.pedido');
Route::get('/pdf/{id}', 'OrdersController@pdfVenta')->name('venta.pdf');
Route::put('/update', 'OrdersController@update')->name('pedido.update');
Route::get('/{id}', 'OrdersController@show')->name('show.pedido');

});


Route::group(['prefix' => '/cart'], function () {

    Route::get('/', 'HomeController@cart')->name('store.cart')->middleware('auth');
    Route::post('/add_product', 'CarController@store')->name('cart.product');
    Route::post('/updateCart', 'CarController@update')->name('cart.update');
    Route::delete('/{carrito}/delete', 'CarController@delete')->name('cart.destroy');
    Route::get('/buscarCarrito', 'CarController@buscarCarrito')->name('cart.buscarCarrito');
    
});

Route::group(['prefix' => '/devoluciones'], function () {

    Route::get('/', 'DevolucionController@index')->name('devolucion.index');
    Route::get('/producto', 'DevolucionController@devolucionProducto')->name('devolucion.producto');
    Route::post('/store', 'DevolucionController@store')->name('devolucion.store');
    
});


Route::group(['prefix' => "/admin", "middleware" => [sprintf("role:%s", \App\Role::ADMIN)]], function() {
    Route::get('/', 'AdminController@index')->name('admin');

    Route::group(['prefix' => '/dashboard'], function () {

        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('/ventas', 'DashboardController@loadVentas')->name('dashboard.ventas');
        
    });

    Route::group(['prefix' => '/informes'], function () {
        Route::get('/ventas', 'InformesController@informeVentas')->name('informes.ventas');
        Route::get('/ventas/listado/{mes}', 'InformesController@mostrarVentas')->name('listado.ventas');
        Route::get('/productos', 'InformesController@ventaProductos')->name('informes.productos');
        Route::get('/clientes', 'InformesController@informeClientes')->name('informes.clientes');
        Route::get('/pdf/ventas', 'InformesController@pdfInformeVentas')->name('informes.ventaspdf');
        Route::get('/pdf/productos', 'InformesController@pdfInformeProductos')->name('informes.productospdf');
        Route::get('/pdf/clientes', 'InformesController@pdfInformeClientes')->name('informes.clientespdf');
        Route::get('/pdf/ventas/mes', 'InformesController@pdfVentaShow')->name('informes.ventashowpdf');
    
    });

    Route::group(['prefix' => '/devoluciones'], function () {

        Route::get('/listar', 'DevolucionController@listarDevolucion')->name('devolucion.lista');
        Route::put('/update', 'DevolucionController@update')->name('devolucion.update');
        Route::get('/{id}', 'DevolucionController@mostrarDevolucion')->name('devolucion.show');
    });
    
    Route::group(['prefix' => '/categorias'], function () {
    
        Route::get('/', 'CategoryController@index')->name('category.index');
        Route::get('/create', 'CategoryController@create')->name('category.create');
        Route::post('/', 'CategoryController@store')->name('category.store');
        Route::get('/{slug}/edit', 'CategoryController@edit')->name('category.edit');
        Route::put('/{categoria}/update', 'CategoryController@update')->name('category.update');
        Route::delete('/{categoria}/delete', 'CategoryController@destroy')->name('category.destroy');
        Route::get('/{categoria}', 'CategoryController@show')->name('category.show');
    
    });
    
    Route::group(['prefix' => '/subcategorias'], function () {
    
        Route::get('/', 'SubcategoryController@index')->name('subcategory.index');
        Route::get('/create', 'SubcategoryController@create')->name('subcategory.create');
        Route::post('/', 'SubcategoryController@store')->name('subcategory.store');
        Route::get('/{slug}/edit', 'SubcategoryController@edit')->name('subcategory.edit');
        Route::put('/{subcategoria}/update', 'SubcategoryController@update')->name('subcategory.update');
        Route::delete('/{subcategoria}/delete', 'SubcategoryController@destroy')->name('subcategory.destroy');
        Route::get('/getSubcategoria', 'SubcategoryController@getSubcategoria')->name('subcategory.get');
        Route::get('/{subcategoria}', 'SubcategoryController@show')->name('subcategory.show');
       
    });

    Route::group(['prefix' => '/tipo_producto'], function () {

        Route::get('/', 'TipoProductoController@index')->name('tipo.index');
        Route::get('/create', 'TipoProductoController@create')->name('tipo.create');
        Route::post('/', 'TipoProductoController@store')->name('tipo.store');
        Route::get('/{slug}/edit', 'TipoProductoController@edit')->name('tipo.edit');
        Route::put('/{tipo}/update', 'TipoProductoController@update')->name('tipo.update');
        Route::delete('/{tipo}/delete', 'TipoProductoController@destroy')->name('tipo.destroy');
        Route::get('/list', 'TipoProductoController@getTipo')->name('tipo.get');
        Route::get('/{tipo}', 'TipoProductoController@show')->name('tipo.show');

    });

    Route::group(['prefix' => '/productos'], function () {
    
        Route::get('/', 'ProductController@index')->name('product.index');
        Route::get('/create', 'ProductController@create')->name('product.create');
        Route::post('/', 'ProductController@store')->name('product.store');
        Route::post('/newColor', 'ProductController@storeColor')->name('product.storeColor');
        Route::get('/{slug}/edit', 'ProductController@edit')->name('product.edit');
        Route::put('/{producto}/update', 'ProductController@update')->name('product.update');
        Route::put('/visitas/update/{id}', 'ProductController@setVisitas')->name('product.visitas');
        Route::delete('/{producto}/delete', 'ProductController@destroy')->name('product.destroy');
        Route::delete('/eliminarimagen/{id}','ProductController@eliminarImagen')->name('product.eliminarimagen');
        Route::get('/add_color/{slug}', 'ProductController@addColor')->name('product.color');
        Route::get('/{producto}', 'ProductController@show')->name('product.show');
        
    });
    
    Route::group(['prefix' => '/proveedores'], function () {
    
        Route::get('/', 'ProveedorController@index')->name('proveedor.index');
        Route::get('/create', 'ProveedorController@create')->name('proveedor.create');
        Route::post('/', 'ProveedorController@store')->name('proveedor.store');
        Route::get('/{slug}/edit', 'ProveedorController@edit')->name('proveedor.edit');
        Route::put('/{proveedor}/update', 'ProveedorController@update')->name('proveedor.update');
        Route::delete('/{proveedor}/delete', 'ProveedorController@destroy')->name('proveedor.destroy');
        Route::get('/{proveedor}', 'ProveedorController@show')->name('proveedor.show');
        
    });
    

    Route::group(['prefix' => '/stock'], function (){
        Route::get('/', 'StockController@index')->name('stock.index');
        Route::post('/', 'StockController@store')->name('stock.store');

    });

    Route::group(['prefix' => '/tallas'], function (){
        Route::get('/', 'TallaController@getTalla')->name('talla.get');
        Route::get('/productos/{id}', 'TallaController@getProductoTallas')->name('talla.productos');
    });

    Route::group(['prefix' => '/ventas'], function () {

        Route::get('/', 'VentaController@index')->name('venta.index');
        Route::post('/store', 'VentaController@store')->name('venta.store');
        Route::get('/pdf/{id}', 'VentaController@pdfVenta')->name('venta.pdf');
        Route::get('/{venta}', 'VentaController@show')->name('venta.show');
        
    });
        

    Route::group(['prefix' => '/clientes'], function (){
        Route::get('/', 'ClienteController@index')->name('cliente.index');
        Route::get('/{id}', 'ClienteController@show')->name('cliente.show');
        Route::post('/send_message', 'ClienteController@sendMessage')->name('cliente.message');
    });

});


Route::get('cancelar/{ruta}', function($ruta) {
    session()->flash('message', ['danger', ("Acción cancelada")]);
    return redirect()->route($ruta);
})->name('cancelar');
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
