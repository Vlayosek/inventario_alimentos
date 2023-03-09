<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role_has_permission extends Model
{
    public $timestamps = false;
    protected $table = 'role_has_permission';
    protected $connection = 'pgsql';
    protected $primaryKey = ['menu_id','role_id'];
    protected $fillable = ['menu_id',
        'role_id',

    ];
}
