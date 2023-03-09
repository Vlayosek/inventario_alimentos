<?php

namespace App\Core\Entities\Admin;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $connection = 'pgsql';
}
