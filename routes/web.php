<?php

use App\Http\Controllers\HistoriasMedicas\GenerarArchivoController;

ob_start();

require __DIR__ . '/modulos/adminC.php';


Route::get('storage/{carpeta}/{carpeta2}/{archivo}/{local}', [GenerarArchivoController::class, 'descargar']);
