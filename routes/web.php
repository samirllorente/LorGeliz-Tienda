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
Route::get('/index', 'HomeController@productsIndex');
Route::get('/categorias', 'HomeController@categorias')->name('categorias');

Route::get('/checkout', 'HomeController@checkout')->name('checkout')->middleware('auth');
Route::get('/categorias/productos', 'HomeController@getProductos')->name('categorias.productos');
Route::get('/categorias/productos/estado', 'HomeController@getProductosByState')->name('productos.estados');
Route::get('/categorias/productos/vendidos', 'HomeController@getProductosSales')->name('productos.sale');
Route::get('/categorias/productos/vistos', 'HomeController@getProductosVisitas')->name('productos.view');
Route::get('/categorias/productos/orden', 'HomeController@getProductsByOrder')->name('productos.orden');
Route::get('/categorias/productos/tipo', 'HomeController@getProductsByTipo')->name('productos.tipo');
Route::get('/categorias/productos/genero', 'HomeController@getProductsByGenre')->name('productos.genero');
Route::get('/product/{slug}', 'HomeController@product')->name('producto.show');

Route::get('/cuenta', 'UserController@index')->name('users.cuenta');
Route::get('/contacto', 'ContactoController@contacto')->name('contact');
Route::put('/update', 'UserController@update')->name('users.update');

Route::get('/tallas/productos/{id}', 'TallaController@getProductoTallas')->name('talla.productos');
Route::put('/productos/visitas/update/{id}', 'ProductController@setVisitas')->name('product.visitas');
Route::get('/payments/epayco/response', 'PaymentController@response')->name('response');

Route::group(['prefix' => '/stock'], function (){
    Route::get('/verificar', 'StockController@verificarStock')->name('stock.verificar');
});

Route::group(['prefix' => '/pedidos'], function () {

Route::get('/', 'OrdersController@index')->name('pedidos.index');
Route::get('/show/pdf/{id}', 'OrdersController@showPdf')->name('pedidos.show.pdf');
Route::get('/factura/{id}', 'OrdersController@facturas')->name('pedidos.factura');
Route::get('/{id}', 'OrdersController@show')->name('pedidos.show');

});

Route::group(['prefix' => '/cart'], function () {

    Route::get('/', 'CarController@index')->name('cart.index'); 
    //Route::get('/user', 'CarController@getProductsUser')->name('cart.products');
    Route::get('/products', 'CarController@userCart')->name('cart.user');
    Route::post('/store', 'CarController@store')->name('cart.store');
    Route::post('/update', 'CarController@update')->name('cart.update');
    Route::post('/setCantidad', 'CarController@updateProduct')->name('cart.updateProduct');
    Route::delete('/remove/{producto}', 'CarController@remove')->name('cart.remove');
    Route::delete('/delete/{carrito}', 'CarController@destroy')->name('cart.destroy');
    Route::get('/buscarCarrito', 'CarController@buscarCarrito')->name('cart.buscarCarrito');
    
});

Route::group(['prefix' => '/devoluciones'], function () {

    Route::get('/', 'DevolucionController@index')->name('devolucion.index');
    Route::get('/producto', 'DevolucionController@devolucionProducto')->name('devolucion.producto');
    Route::post('/store', 'DevolucionController@store')->name('devolucion.store');
});

Route::group(['prefix' => '/ventas'], function () {
    Route::post('/epayco', 'VentaController@epayco_register')->name('venta.epayco');
    Route::post('/epayco/confirm', 'VentaController@epaycoConfirm')->name('venta.confirmation'); //ruta para confirmación, de prueba
    Route::post('/store', 'VentaController@store')->name('venta.store');
});

Route::group(['prefix' => '/notification'], function () {
    Route::get('/client', 'NotificationController@clientNotification')->name('notification.client');
    Route::get('/cart/client', 'NotificationController@cartNotification')->name('notification.cart');
    Route::put('/client/read/{id}', 'NotificationController@setClientRead')->name('notification.readClient');
});

Route::group(['prefix' => "/admin", "middleware" => [sprintf("role:%s", \App\Role::ADMIN)]], function() {
    Route::get('/', 'AdminController@index')->name('admin');

    Route::group(['prefix' => '/dashboard'], function () {

        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('/ventas', 'DashboardController@loadVentas')->name('dashboard.ventas');
        
    });

    Route::group(['prefix' => '/notification'], function () {
        Route::get('/get', 'NotificationController@getNotification')->name('notification');
        Route::put('/read/{id}', 'NotificationController@setRead')->name('notification.read');
    });

    Route::group(['prefix' => '/informes'], function () {
        Route::get('/ventas', 'InformesController@informeVentas')->name('informes.ventas');
        Route::get('/ventas/listado/{mes}', 'InformesController@mostrarVentas')->name('listado.ventas');
        Route::get('/productos', 'InformesController@ventaProductos')->name('informes.productos');
        Route::get('/clientes', 'InformesController@informeClientes')->name('informes.clientes');
        Route::get('/pagos', 'InformesController@informePagos')->name('informes.pagos');
        Route::get('/pagos/listado/{mes}', 'InformesController@mostrarPagos')->name('listado.pagos');
        Route::get('/pdf/ventas', 'InformesController@pdfInformeVentas')->name('informes.ventaspdf');
        Route::get('/pdf/productos', 'InformesController@pdfInformeProductos')->name('informes.productospdf');
        Route::get('/pdf/clientes', 'InformesController@pdfInformeClientes')->name('informes.clientespdf');
        Route::get('/pdf/ventas/mes', 'InformesController@pdfVentaShow')->name('informes.ventashowpdf');
    
    });

    Route::group(['prefix' => '/devoluciones'], function () {

        Route::get('/clientes', 'DevolucionController@listarDevolucion')->name('devolucion.lista');
        Route::get('/listado', 'DevolucionController@pdfListarDevoluciones')->name('devolucion.listado');
        Route::put('/update', 'DevolucionController@update')->name('devolucion.update');
        Route::get('/{id}', 'DevolucionController@show')->name('devolucion.show');
    });
    
    Route::group(['prefix' => '/payments'], function (){
        Route::get('/', 'PaymentController@index')->name('payments.index');
        Route::get('/payment/{id}', 'PaymentController@printPay')->name('payments.pdf');
        Route::get('/list', 'PaymentController@pdfPagosReporte')->name('payments.list');
       // Route::get('/epayco/response', 'PaymentController@response')->name('response');
    });

    Route::group(['prefix' => '/productos'], function () {
    
        //Route::get('/', 'ProductController@index')->name('product.index');
        Route::get('/{id}/colores', 'ProductController@product')->name('product.colors');
        Route::get('/color/{slug}', 'ProductController@showColor')->name('product.showColor');
        //Route::get('/create', 'ProductController@create')->name('product.create');
        //Route::post('/', 'ProductController@store')->name('product.store');
        Route::post('/newColor', 'ProductController@storeColor')->name('product.storeColor');
        Route::post('{id}/activate', 'ProductController@activate')->name('product.activate');
        //Route::get('/{id}/edit', 'ProductController@edit')->name('product.edit');
        Route::get('/editar/{slug}', 'ProductController@editColor')->name('product.editColor');
        //Route::put('/{producto}/update', 'ProductController@update')->name('product.update');
        Route::put('/update/{slug}', 'ProductController@updateColor')->name('product.updateColor');
        //Route::delete('{id}/delete', 'ProductController@destroy')->name('product.destroy');
        Route::delete('/eliminarimagen/{id}','ProductController@eliminarImagen')->name('product.eliminarimagen');
        Route::get('/add_color/{id}', 'ProductController@createColor')->name('product.color');
       
        //Route::get('/{id}', 'ProductController@show')->name('product.show');
        
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
        Route::get('/listado', 'StockController@pdfInventarios')->name('stock.listadopdf');
        Route::post('/', 'StockController@store')->name('stock.store');
    });

    Route::group(['prefix' => '/tallas'], function (){
        Route::get('/', 'TallaController@getTalla')->name('talla.get')->middleware('auth');
    });

    Route::group(['prefix' => '/ventas'], function () {

        Route::get('/', 'VentaController@index')->name('venta.index');
        Route::put('/anular/{venta}', 'VentaController@anular')->name('venta.anular');
        Route::put('/pagar/{venta}', 'VentaController@registrarPago')->name('venta.pagar');
        //Route::post('/epayco', 'VentaController@epayco_register')->name('venta.epayco');
        //Route::post('/store', 'VentaController@store')->name('venta.store');
        Route::get('/factura/{id}', 'VentaController@facturaVentaAdmin')->name('venta.factura');
        Route::get('/listado','VentaController@listadoVentasPdf')->name('venta.listado');
        Route::get('/{venta}', 'VentaController@show')->name('venta.show');
        
    });
    
    Route::group(['prefix' => '/pedidos'], function () {

        Route::get('/clientes', 'OrdersController@listarPedidos')->name('pedidos.clientes');
        Route::get('/pedido/pdf/{id}', 'OrdersController@imprimirPedido')->name('pedidos.imprimir');
        Route::get('/pedido/{id}', 'OrdersController@showPedidoAdmin')->name('pedidos.show-id');
        Route::get('/listado/pdf', 'OrdersController@reportePedidosPdf')->name('pedidos.reporte');
        Route::put('/update', 'OrdersController@update')->name('pedido.update');
    });

    Route::group(['prefix' => '/clientes'], function (){
        Route::get('/', 'ClienteController@index')->name('cliente.index');
        Route::get('/listado', 'ClienteController@pdfListadoClientes')->name('cliente.listado');
        Route::get('/{id}', 'ClienteController@show')->name('cliente.show');
        Route::post('/send_message', 'ClienteController@sendMessage')->name('cliente.message');
    });

    //Route::group(['prefix' => '/categorias'], function () {
    
        //Route::get('/', 'CategoryController@index')->name('category.index');
        //Route::get('/create', 'CategoryController@create')->name('category.create');
        //Route::post('/', 'CategoryController@store')->name('category.store');
        //Route::get('/{slug}/edit', 'CategoryController@edit')->name('category.edit');
        //Route::put('/{categoria}/update', 'CategoryController@update')->name('category.update');
        //Route::delete('/{categoria}/delete', 'CategoryController@destroy')->name('category.destroy');
        //Route::get('/{categoria}', 'CategoryController@show')->name('category.show');
    
    //});

    //Route::group(['prefix' => '/subcategorias'], function () {
    
        //Route::get('/', 'SubcategoryController@index')->name('subcategory.index');
        //Route::get('/create', 'SubcategoryController@create')->name('subcategory.create');
        //Route::post('/', 'SubcategoryController@store')->name('subcategory.store');
        //Route::get('/{slug}/edit', 'SubcategoryController@edit')->name('subcategory.edit');
        //Route::put('/{subcategoria}/update', 'SubcategoryController@update')->name('subcategory.update');
        //Route::delete('/{subcategoria}/delete', 'SubcategoryController@destroy')->name('subcategory.destroy');
        //Route::get('/getSubcategoria', 'SubcategoryController@getSubcategoria')->name('subcategory.get');
        //Route::get('/{subcategoria}', 'SubcategoryController@show')->name('subcategory.show');
       
    //});

    //Route::group(['prefix' => '/tipo_producto'], function () {

        //Route::get('/', 'TipoProductoController@index')->name('tipo.index');
        //Route::get('/create', 'TipoProductoController@create')->name('tipo.create');
        //Route::post('/', 'TipoProductoController@store')->name('tipo.store');
        //Route::get('/{slug}/edit', 'TipoProductoController@edit')->name('tipo.edit');
        //Route::put('/{tipo}/update', 'TipoProductoController@update')->name('tipo.update');
        //Route::delete('/{tipo}/delete', 'TipoProductoController@destroy')->name('tipo.destroy');
        //Route::get('/list', 'TipoProductoController@getTipo')->name('tipo.get');
        //Route::get('/{tipo}', 'TipoProductoController@show')->name('tipo.show');

    //});

    Route::resource('/product', 'ProductController');

    Route::get('/subcategory/getSubcategoria', 'SubcategoryController@getSubcategoria')->name('subcategory.get');
    Route::resource('/subcategory', 'SubcategoryController');

    Route::get('/tipos/lista', 'TipoProductoController@getTipo')->name('tipo.get');
    Route::resource('/tipo', 'TipoProductoController');

    Route::resource('/category', 'CategoryController');

});

//Route::resource('/car', 'CarController');

Route::get('cancelar/{ruta}', function($ruta) {
    session()->flash('message', ['danger', ("Acción cancelada")]);
    return redirect()->route($ruta);
})->name('cancelar');

Auth::routes();

