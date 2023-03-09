<?php

namespace App\Core\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class mhr extends Model
{
    protected $table = 'model_has_roles';
    protected $connection = 'pgsql';
    public $timestamps = false;

}
