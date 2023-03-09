<?php

namespace App\Core\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    protected $table = 'roles';
    protected $connection = 'pgsql';
    public $timestamps = false;
 
}
