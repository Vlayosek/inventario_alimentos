<?php

namespace App\Core\Entities\InventarioAlimentos;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
  protected $table = 'sc_inventario_alimentos.logs';
  protected $connection = 'pgsql_presidencia';
  protected $primaryKey = 'id';
  public $timestamps = false;
  protected $fillable = [
    'anterior',
    'actual',
    'valor',
    'campo',
    'tabla_id',
    'tabla'

  ];
}
