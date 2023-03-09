<?php

namespace App\Core\Entities\InventarioAlimentos;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
  protected $table = 'sc_inventario_alimentos.devoluciones';
  protected $connection = 'pgsql_presidencia';
  protected $primaryKey = 'id';
  public $timestamps = false;

  protected $fillable = [
    'producto',
    'cantidad',
    'medida',
    'tipo',
    'observacion_eliminacion',
    'fecha_devolucion'
  ];
}
