<?php

namespace App\Core\Entities\InventarioAlimentos;

use Illuminate\Database\Eloquent\Model;

class Necesidad extends Model
{
  protected $table = 'sc_inventario_alimentos.necesidades';
  protected $connection = 'pgsql_presidencia';
  protected $primaryKey = 'id';
  public $timestamps = false;
  protected $fillable = [
    'persona_id',
    'fecha_solicitud',
    'observacion',
    'historia_laboral_id',
    'aceptada',
  ];
}
