<?php

namespace App\Core\Entities\InventarioAlimentos;

use Illuminate\Database\Eloquent\Model;

class NecesidadDetalle extends Model
{
  protected $table = 'sc_inventario_alimentos.necesidades_detalles';
  protected $connection = 'pgsql_presidencia';
  protected $primaryKey = 'id';
  public $timestamps = false;

  protected $fillable = [
    'necesidad_id',
    'producto',
    'cantidad',
    'medida',
    'tipo',
    'observacion_eliminacion',
    'producto_id',
  ];
}
