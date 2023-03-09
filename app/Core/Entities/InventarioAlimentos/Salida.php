<?php

namespace App\Core\Entities\InventarioAlimentos;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
  protected $table = 'sc_inventario_alimentos.salidas';
  protected $connection = 'pgsql_presidencia';
  protected $primaryKey = 'id';
  public $timestamps = false;

  protected $fillable = [
    'producto',
    'fecha_salida',
    'cantidad',
    'medida',
    'tipo',
    'observacion_eliminacion'
  ];
}
