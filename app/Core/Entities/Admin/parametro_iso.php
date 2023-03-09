<?php

namespace App\Core\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class parametro_iso extends Model
{
    public $timestamps = true;
    protected $table = 'parametro_iso';
    protected $connection = 'pgsql';
    protected $primaryKey = 'id';
 
    public function fatherpara(){
        return $this->belongsTo('App\Core\Entities\Admin\parametro_iso','id','parametro_id');
    }

}
