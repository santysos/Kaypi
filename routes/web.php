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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('ventas/procesos', 'ProcesosController');

Route::get('ventas/procesos/dp/{id}', 'ProcesosController@getDescripcionProcesos');
Route::get('ventas/procesos/pro/{id}', 'ProcesosController@getProcesos');

Route::resource('departamentos/departamento','DepartamentoController');
Route::resource('departamentos/procesos', 'DescripcionProcesosController');
/* 
Rutas Ventas 
*/
Route::get('ventas/ordenes/borrar/{id}', 'OrdenesController@borrarorden');
Route::resource('ventas/ordenes','OrdenesController');
Route::resource('ventas/cliente','ClienteController');
Route::resource('ventas/venta','VentaController');
Route::resource('buscar','BuscarController');
Route::resource('ventas/reportes', 'ReportesController');
Route::resource('ventas/produccion', 'ProduccionController');

Route::resource('compras/proveedor','ProveedorController');
Route::resource('compras/ingreso','IngresoController');
Route::resource('compras/retenciones','RetencionController');
Route::get('compras/retenciones/bcli/{id}', 'RetencionController@getProveedor');
Route::get('compras/retenciones/impret/{id}', 'RetencionController@getImpuestos');

Route::resource('pagos/tipopago', 'TipoPagoController');
Route::resource('pagos/pago', 'PagosController');


Route::resource('pruebas', 'PruebasController');
route::get('/art/venta/articulo','PruebasController@getArticulos');

/*Route::get('art/venta/articulo',function(){
    return Kaypi\Articulo::where('nombre', 'LIKE', '%' . request('q') . '%')->paginate(10);
});*/

Route::get('ventas/venta/dsp/{id}', 'VentaController@getPrecios');
Route::get('ventas/venta/pagos/{id}', 'VentaController@getPagos');
Route::get('ventas/venta/numComp/{id}', 'VentaController@getNumComprobante');

Route::get('ventas/ordenes/dsp/{id}', 'VentaController@getPrecios');

Route::get('reportec/{id}','VentaController@reportec');

Route::get('ventas/ordenes/ds/{id}', 'OrdenesController@getDescripcionServicios');

Route::get('ventas/ordenes/bcli/{id}', 'OrdenesController@getClientes');


Route::resource('almacen/articulo','ArticuloController');
Route::resource('almacen/articulo1','Articulo1Controller');
Route::resource('almacen/articulo2','Articulo2Controller');
Route::resource('almacen/categoria','CategoriaController');

Route::resource('roles/usuario','UsuarioController');
Route::resource('roles/empleados','TipoEmpleadoController');
Route::get('roles/usuario/tm/{id}', 'UsuarioController@getTipoEmpleado');
Route::get('roles/usuario/tm/{id}', 'UsuarioController@getTipoEmpleado');

Route::get('reportes1','Articulo1Controller@reportes');
Route::get('reportes2','Articulo2Controller@reportes');
Route::get('reportec1/{id}', 'ImprimirController@reportec');


