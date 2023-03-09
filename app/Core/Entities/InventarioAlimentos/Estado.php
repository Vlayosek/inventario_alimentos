<?php

namespace App\Core\Entities\InventarioAlimentos;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
  protected $table = 'sc_inventario_alimentos.estados';
  protected $connection = 'pgsql_presidencia';
  protected $primaryKey = 'id';
  public $timestamps = false;

  protected $fillable = [
    'nombre',
    'descripcion',
    'estado',
    'fecha_inserta',
    'usuario_inserta',
    'usuario_modifica',
    'fecha_modifica',
    'eliminado',
    'visible',
    'orden',
  ];

  public function estado_solicitud()
  {
    return $this->hasOne('App\Core\Entities\InventarioAlimentos\EstadoNecesidad',  'descripcion', 'nombre');
  }
}
