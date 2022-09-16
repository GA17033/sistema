<?php

use App\Http\Controllers\BoletaVenta;
use App\Http\Controllers\CambiarClaveController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\RecuperarClave;
use App\Http\Controllers\RecuperarClaveController;
use App\Http\Controllers\ReporteVentaController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HerramientaController;
use App\Http\Controllers\InventarioController;

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
    //return view('welcome');
    return redirect()->route("home");
});

Auth::routes(['verify' => true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* SENTRY */
Route::get('/errores', function () {
    throw new Exception('My first Sentry error!');
});


/* tipo usuario */
Route::get('/tipo-usuario', [TipoUsuarioController::class, 'index'])->name("tipo.index")->middleware('verified');
Route::post('/tipo-usuario-crear', [TipoUsuarioController::class, 'create'])->name("tipo.create")->middleware('verified');
Route::post('/tipo-usuario-actualizar-{id}', [TipoUsuarioController::class, 'update'])->name("tipo.update")->middleware('verified');
Route::get('/tipo-usuario-eliminar-{id}', [TipoUsuarioController::class, 'destroy'])->name("tipo.destroy")->middleware('verified');

/* usuario */
Route::get("/usuario", [UsuarioController::class, "index"])->name("usuario.index")->middleware("verified");
Route::get("/usuario-crear", [UsuarioController::class, "create"])->name("usuario.create")->middleware("verified");
Route::post("/usuario-registrar", [UsuarioController::class, "store"])->name("usuario.store")->middleware("verified");
Route::post("/usuarioActualizar-{id}", [UsuarioController::class, "update"])->name("usuario.update")->middleware('verified');
Route::get("/usuario-editar-{id}", [UsuarioController::class, "edit"])->name("usuario.edit")->middleware('verified');
Route::post("/usuario-modificarImagen", [UsuarioController::class, "actualizarImagen"])->name("usuario.actualizarImagen")->middleware('verified');
Route::get("/usuario-eliminarImagen-{id}", [UsuarioController::class, "eliminarImagen"])->name("usuario.eliminarImagen")->middleware('verified');
Route::get("/usuario-eliminar-{id}", [UsuarioController::class, "destroy"])->name("usuario.destroy")->middleware('verified');

/* clientes */
Route::get("/cliente", [ClienteController::class, "index"])->name("cliente.index")->middleware("verified");

/* categoria */
Route::get("/categoria", [CategoriaController::class, "index"])->name("categoria.index")->middleware("verified");
Route::get("/categoria-crear", [CategoriaController::class, "create"])->name("categoria.create")->middleware("verified");
Route::post("/categoria-registrar", [CategoriaController::class, "store"])->name("categoria.store")->middleware("verified");
Route::post("/categoria-{id}", [CategoriaController::class, "update"])->name("categoria.update")->middleware('verified');
Route::get("/categoria-editar-{id}", [CategoriaController::class, "edit"])->name("categoria.edit")->middleware('verified');
Route::get("/categoria-eliminar-{id}", [CategoriaController::class, "destroy"])->name("categoria.destroy")->middleware('verified');


/* producto */
Route::get("/producto", [ProductoController::class, "index"])->name("producto.index")->middleware("verified");
Route::get("/producto-crear", [ProductoController::class, "create"])->name("producto.create")->middleware("verified");
Route::post("/producto-registrar", [ProductoController::class, "store"])->name("producto.store")->middleware("verified");
Route::post("/producto-{id}", [ProductoController::class, "update"])->name("producto.update")->middleware('verified');
Route::get("/producto-editar-{id}", [ProductoController::class, "edit"])->name("producto.edit")->middleware('verified');
Route::get("/producto-eliminar-{id}", [ProductoController::class, "destroy"])->name("producto.destroy")->middleware('verified');


/* proveedor */
Route::get("/proveedor", [ProveedorController::class, "index"])->name("proveedor.index")->middleware("verified");
Route::get("/proveedor-crear", [ProveedorController::class, "create"])->name("proveedor.create")->middleware("verified");
Route::post("/proveedor-registrar", [ProveedorController::class, "store"])->name("proveedor.store")->middleware("verified");
Route::post("/proveedor-{id}", [ProveedorController::class, "update"])->name("proveedor.update")->middleware('verified');
Route::get("/proveedor-editar-{id}", [ProveedorController::class, "edit"])->name("proveedor.edit")->middleware('verified');
Route::get("/proveedor-eliminar-{id}", [ProveedorController::class, "destroy"])->name("proveedor.destroy")->middleware('verified');

/*proyecto */

Route::get('/proyectos', [ProyectoController::class, "index"])->name('proyecto.index')->middleware("verified");
Route::get("/proyectos-crear", [ProyectoController::class, "create"])->name("proyecto.create")->middleware("verified");
Route::post("/proyectos-registrar", [ProyectoController::class, "store"])->name("proyecto.store")->middleware("verified");
Route::post("/proyectos-{id}", [ProyectoController::class, "update"])->name("proyecto.update")->middleware('verified');
Route::get("/proyectos-editar-{id}", [ProyectoController::class, "edit"])->name("proyecto.edit")->middleware('verified');
Route::get("/proyectos-eliminar-{id}", [ProyectoController::class, "destroy"])->name("proyecto.destroy")->middleware('verified');




/* entrada */
Route::get("/entrada", [EntradaController::class, "index"])->name("entrada.index")->middleware("verified");
Route::get("/entrada-crear", [EntradaController::class, "create"])->name("entrada.create")->middleware("verified");
Route::post("/entrada-registrar", [EntradaController::class, "store"])->name("entrada.store")->middleware("verified");
Route::post("/entrada-{id}", [EntradaController::class, "update"])->name("entrada.update")->middleware('verified');
Route::get("/entrada-editar-{id}", [EntradaController::class, "edit"])->name("entrada.edit")->middleware('verified');
Route::get("/entrada-eliminar-{id}", [EntradaController::class, "destroy"])->name("entrada.destroy")->middleware('verified');


/* salida */
Route::get("/salida", [SalidaController::class, "index"])->name("salida.index")->middleware("verified");
Route::get("/buscar-producto/{id}", [SalidaController::class, "buscar"])->name("salida.buscar")->middleware("verified");
Route::get("/agregar-elemento/{id}", [SalidaController::class, "agregarElemento"])->name("salida.buscar")->middleware("verified");
Route::post("/registrar-salida", [SalidaController::class, "registrarVenta"])->name("salida.registrar")->middleware("verified");
Route::get("/salida-venta", [SalidaController::class, "venta"])->name("salida.venta")->middleware("verified");
Route::get("/salida-eliminar-{id}", [SalidaController::class, "eliminar"])->name("salida.eliminar")->middleware("verified");
/* reportes venta ticket y pdf */
Route::get('ver-pdf-ventas-{id}', [ReporteVentaController::class, 'prueba'])->name('reporte.prueba');
Route::get('ver-ticket-ventas-{id}', [ReporteVentaController::class, 'ticket'])->name('reporte.ticket');
/* reportes de venta dia-mes-año */
Route::get('reporte-hoy', [ReporteVentaController::class, 'reHoy'])->name('reporte.hoy')->middleware("verified");
Route::get('reporte-dia-index', [ReporteVentaController::class, 'diaIndex'])->name('dia.index')->middleware("verified");
Route::get('reporte-dia-search/{id}', [ReporteVentaController::class, 'reDia'])->name('dia.search')->middleware("verified");
Route::get('reporte-dias-index', [ReporteVentaController::class, 'diasIndex'])->name('dias.index')->middleware("verified");
Route::get('reporte-dias-search/{id}/{fe}', [ReporteVentaController::class, 'reDias'])->name('dias.search')->middleware("verified");
Route::get('reporte-mes-index', [ReporteVentaController::class, 'mesIndex'])->name('mes.index')->middleware("verified");
Route::get('reporte-mes-search/{id}', [ReporteVentaController::class, 'reMes'])->name('mes.search')->middleware("verified");
Route::get('reporte-meses-index', [ReporteVentaController::class, 'mesesIndex'])->name('meses.index')->middleware("verified");
Route::get('reporte-meses-search/{id}/{fe}', [ReporteVentaController::class, 'reMeses'])->name('meses.search')->middleware("verified");
Route::get('reporte-anio-index', [ReporteVentaController::class, 'anioIndex'])->name('anio.index')->middleware("verified");
Route::get('reporte-anio-search/{id}', [ReporteVentaController::class, 'reAnio'])->name('anio.search')->middleware("verified");
Route::get('reporte-anios-index', [ReporteVentaController::class, 'aniosIndex'])->name('anios.index')->middleware("verified");
Route::get('reporte-anios-search/{id}/{fe}', [ReporteVentaController::class, 'reAnios'])->name('anios.search')->middleware("verified");
Route::get('reporte-prod-max-index', [ReporteVentaController::class, 'reProdMax'])->name('prod.index')->middleware("verified");
/* reporte de pdf */

Route::get('reporte-pdf-hoy', [ReporteVentaController::class, 'pdfHoy'])->name('pdf.hoy')->middleware("verified");
Route::get('reporte-pdf-dia-{fe}', [ReporteVentaController::class, 'pdfDia'])->middleware("verified");
Route::get('reporte-pdf-dias/{fe}/and/{fe2}', [ReporteVentaController::class, 'pdfDias'])->middleware("verified");
Route::get('reporte-pdf-mes/{fe}', [ReporteVentaController::class, 'pdfMes'])->middleware("verified");
Route::get('reporte-pdf-meses/{fe}/and/{fe2}', [ReporteVentaController::class, 'pdfMeses'])->middleware("verified");
Route::get('reporte-pdf-anio-{fe}', [ReporteVentaController::class, 'pdfAnio'])->middleware("verified");
Route::get('reporte-pdf-anios/{fe}/and/{fe2}', [ReporteVentaController::class, 'pdfAnios'])->middleware("verified");
Route::get('reporte-pdf-prod', [ReporteVentaController::class, 'pdfProd'])->name('pdf.prod')->middleware("verified");


/* boleta de venta */
Route::get("/salida-boleta", [BoletaVenta::class, "boleta"])->name("salida.boleta")->middleware("verified");
Route::get("/salida-boleta-buscar/{id}", [BoletaVenta::class, "buscarBoleta"])->name("salidaBoleta.buscar")->middleware("verified");



/* info de la empresa */
Route::get("/empresa", [EmpresaController::class, "datos"])->name("empresa.datos")->middleware("verified");
Route::post("/empresa-editar", [EmpresaController::class, "editar"])->name("empresa.update")->middleware('verified');
Route::post("/empresa-edit-img", [EmpresaController::class, "editarImg"])->name("empresa.updateImg")->middleware('verified');
Route::get("/empresa-eliminar-img-{id}", [EmpresaController::class, "eliminarImg"])->name("empresa.destroy")->middleware('verified');


/* info de usuarioProfile */
Route::get("/profile-eliminar-img-{id}", [ProfileController::class, "eliminarImg"])->name("profile.destroy")->middleware('verified');
Route::post("/profile-edit-img", [ProfileController::class, "editarImg"])->name("profile.updateImg")->middleware('verified');
Route::post("/profile-editar", [ProfileController::class, "editar"])->name("profile.update")->middleware('verified');
Route::get("/profile-{id}", [ProfileController::class, "datos"])->name("profile.datos")->middleware("verified");

/* cambiar password */
Route::get("/cambiar-contraseña", function () {
    return view("vistas/cambiarClave/cambiarClave");
})->name("cambiar.pass")->middleware('verified');;



/* recuperar password */
Route::get("/recuperar-contraseña", [RecuperarClaveController::class, 'index'])->name("recuperar.index");
Route::post("/recuperar-contraseña-update", [RecuperarClaveController::class, 'update'])->name("recuperar.update");
Route::get("/nueva-contraseña-index-{id}", [RecuperarClaveController::class, 'nuevoClave'])->name("nuevo.clave");
Route::post("/nueva-contraseña-reset", [RecuperarClaveController::class, 'reset'])->name("reset.clave");



/* respaldo bd */
Route::get('/backup-bd', [CambiarClaveController::class, 'index'])->name("backup.index")->middleware('verified');
Route::post('/backup-update-bd', [CambiarClaveController::class, 'update'])->name("backup.update")->middleware('verified');


/* Herramientas_Proyecto*/

Route::get("/herramientas", [HerramientaController::class, "index"])->name("herramienta.index")->middleware("verified");

/* Herramientas_Proyecto*/
//ruta para ir a vista para agregar herramientas
Route::get("/Herramientas/{id}", [HerramientaController::class, "edit"])->name("herramienta.edit")->middleware('verified');
Route::get("/Herramientas/create/{id}", [HerramientaController::class, "create"])->name("herramienta.create")->middleware('verified');
//Route::post("/Herramientas/index", [HerramientaController::class, "index"])->name("herramienta.index")->middleware('verified');
Route::post("/herramienta/registrar", [HerramientaController::class, "store"])->name("herramienta.store")->middleware("verified");
//Route::get("/herramienta-crear", [HerramientaController::class, "create"])->name("herramienta.create")->middleware("verified");
Route::get("/herramientas-eliminar-{id}", [HerramientaController::class, "destroy"])->name("herramienta.destroy")->middleware('verified');


/* iNVENTARIO */
Route::get("/inventario", [InventarioController::class, "index"])->name("inventario.index")->middleware("verified");
Route::get("/inventario-crear", [InventarioController::class, "create"])->name("inventario.create")->middleware("verified");
Route::post("/inventario-registrar", [InventarioController::class, "store"])->name("inventario.store")->middleware("verified");
Route::get("/inventario-eliminar-{id}", [InventarioController::class, "destroy"])->name("inventario.destroy")->middleware('verified');




