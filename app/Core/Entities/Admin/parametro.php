<?php

namespace App\Core\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class parametro extends Model
{
    public $timestamps = true;
    protected $table = 'parametro';
    protected $connection = 'pgsql';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'descripcion',
                            'parametro_id',
                            'estado',
                            'created_at',
                            'updated_at',
                            'nivel'
    ];
    public function fatherpara(){
        return $this->belongsTo('App\Core\Entities\Admin\parametro','id','parametro_id');
    }
    public function hijos(){
        return $this->hasMany('App\Core\Entities\Admin\parametro','parametro_id','id');
    }
}
