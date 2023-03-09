<?php

namespace App\Core\Entities\InventarioAlimentos;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
  protected $table = 'sc_inventario_alimentos.productos';
  protected $connection = 'pgsql_presidencia';
  protected $primaryKey = 'id';
  public $timestamps = false;

  protected $fillable = [
    'producto',
    'descripcion',
    'estado',
    'eliminado',
    'medida',
    'tipo',
    // 'producto_id',
    // 'precio',
  ];
}
