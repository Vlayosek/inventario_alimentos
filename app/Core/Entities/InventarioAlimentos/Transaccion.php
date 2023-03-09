<?php

namespace App\Core\Entities\InventarioAlimentos;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
  protected $table = 'sc_inventario_alimentos.transacciones';
  protected $connection = 'pgsql_presidencia';
  protected $primaryKey = 'id';
  public $timestamps = false;

  protected $fillable = [
    'descripcion',
    'producto_id',
    'tipo_transaccion',
    'stock_disponible',
    'cantidad',
    'ultima_transaccion',
    'medida',
    'tipo'
  ];
}
