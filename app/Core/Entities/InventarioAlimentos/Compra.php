<?php

namespace App\Core\Entities\InventarioAlimentos;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
  protected $table = 'sc_inventario_alimentos.compras';
  protected $connection = 'pgsql_presidencia';
  protected $primaryKey = 'id';
  public $timestamps = false;

  protected $fillable = [
    'producto',
    'fecha_caducidad',
    'cantidad',
    'medida',
    'valor_medida',
    'tipo',
    'valor_compra',
    'observacion_eliminacion'
  ];
}
