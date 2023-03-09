<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarioAlimentos\ProductoController;
use App\Http\Controllers\InventarioAlimentos\CompraController;
use App\Http\Controllers\InventarioAlimentos\DevolucionController;
use App\Http\Controllers\InventarioAlimentos\SalidaController;
use App\Http\Controllers\InventarioAlimentos\AprobarController;
use App\Http\Controllers\InventarioAlimentos\Cocina\ProductoController as CCP;
use App\Http\Controllers\InventarioAlimentos\Cocina\SolicitudController;

Route::group(
  [
    'middleware' => ['auth'],
    'middleware' => ['role:ANALISTA DE ALIMENTACION'],
    'as' => 'inventario_alimentos.',
    'prefix' => 'inventario_alimentos'
  ],
  function () {

    /**
     * * Rutas para productos
     */
    Route::get('productos', [CCP::class, 'cocinaProducto']);
    Route::get('necesidades', [SolicitudController::class, 'necesidades']);
    Route::post('consultaEstadosNecesidades', [SolicitudController::class, 'consultaEstadosNecesidades']);
    Route::get('datatableNecesidadesPOSTServerSide/{fecha_inicio}/{fecha_fin}/{tipoActual}', [SolicitudController::class, 'datatableNecesidadesPOSTServerSide']);
    Route::post('generarNecesidad', [SolicitudController::class, 'generarNecesidad']);
    Route::get('getDatatableProductosServerSide/{solicitud_id}', [SolicitudController::class, 'getDatatableProductosServerSide']);
    Route::post('agregarProducto', [SolicitudController::class, 'agregarProducto']);
    Route::post('eliminarProducto', [SolicitudController::class, 'eliminarProducto']);
    Route::post('editarProducto', [SolicitudController::class, 'editarProducto']);


    Route::post('guardarProducto', [ProductoController::class, 'guardarProducto']);


    /**
     * * Rutas para compras
     */
    Route::get('index', [CompraController::class, 'index']);
    Route::post('datatableComprasPOSTServerSide', [CompraController::class, 'datatableComprasPOSTServerSide']);
    Route::post('guardarCompra', [CompraController::class, 'guardarCompra']);
    Route::post('eliminarCompra', [CompraController::class, 'eliminarCompra']);
    Route::post('editarCompra', [CompraController::class, 'editarCompra']);
    Route::post('traerDatosProducto', [CompraController::class, 'traerDatosProducto']);


    /**
     * * Rutas para ventas
     */
    Route::get('salidas', [SalidaController::class, 'salidas']);
    Route::post('datatableVentasPOSTServerSide', [SalidaController::class, 'datatableSalidasPOSTServerSide']);
    Route::post('guardarSalida', [SalidaController::class, 'guardarSalida']);
    Route::post('editarSalida', [SalidaController::class, 'editarSalida']);
    Route::post('eliminarVenta', [SalidaController::class, 'eliminarVenta']);



    /**
     * * Rutas para devoluciones
     */
    Route::get('devoluciones', [DevolucionController::class, 'devoluciones']);
    Route::post('datatableDevolucionesPOSTServerSide', [DevolucionController::class, 'datatableDevolucionesPOSTServerSide']);
    Route::post('guardarDevolucion', [DevolucionController::class, 'guardarDevolucion']);
    Route::post('editarDevolucion', [DevolucionController::class, 'editarDevolucion']);
  }
);

Route::group(
  [
    'middleware' => ['auth'],
    'middleware' => ['role:CARONDELET ALIMENTOS'],
    'as' => 'inventario_alimentos.',
    'prefix' => 'inventario_alimentos'
  ],
  function () {
    Route::get('gestion_solicitudes', [AprobarController::class, 'index']);
    Route::get('getDatatableGestionSolicitudesServerSide/{fecha_inicio}/{fecha_fin}/{tipoActual}', [AprobarController::class, 'getDatatableGestionSolicitudesServerSide']);
    Route::post('filtroEstadosGestion', [AprobarController::class, 'filtroEstadosGestion']);
    // Route::post('editarDevolucion', [AprobarController::class, 'editarDevolucion']);
  }
);
