<?php

namespace App\Core\Entities\InventarioAlimentos;

use Illuminate\Database\Eloquent\Model;

class EstadoNecesidad extends Model
{
  protected $table = 'sc_inventario_alimentos.estados_necesidades';
  protected $connection = 'pgsql_presidencia';
  protected $primaryKey = 'id';
  public $timestamps = false;

  protected $fillable = [
    'descripcion',
    'tabla_id',
    'estado',
    'eliminado',
    'fecha_inserta',
    'usuario_inserta',
    'fecha_modifica',
    'usuario_modifica',
    'observacion',
    'usuario_id_inserta',
    'historia_laboral_id',
    'estado_id'
  ];

  public function estado_()
  {
    return $this->hasOne('App\Core\Entities\InventarioAlimentos\Estado',  'id', 'estado_id');
  }
}
