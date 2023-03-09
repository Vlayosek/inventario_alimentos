<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;
use App\Notifications\MailResetPasswordToken;
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable
{
    use Notifiable;
    use Impersonate;
    use HasRoles;

    protected $fillable = ['name', 'email', 'password', 'remember_token','estado','tipo_id','nombreCompleto'];
    protected $append = ['roles_label','estado_label','roles_type'];    
    protected $connection = 'pgsql';
    
    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    public function evaluarole($arrayRoles)
    {
  
        return ($this->roles()->whereIn('role_id',
        $this->roles()->whereIn('name',$arrayRoles)->pluck('id')->toArray())->count());

    }
   /* public function evaluarole($arrayRoles){

        return ($this->roles()->whereIn('role_id',Role::whereIn('name',$arrayRoles)->pluck('id')->toArray())->count());
    }
    */

    public function getRolesLabelAttribute(){

        $label='';
        foreach ($this->roles()->pluck('name') as $role){
            $label.='<span class="label label-info label-many">'.$role.'</span> ';
        }

        return $label;
    }

    public function getRolesTypeAttribute(){

        $roleTypeArray=[];
        foreach ($this->roles as $role){
            $roleType[]=$role->abv.'-'.$role->id;
        }

        return $roleType;
    }

    public function getEstadoLabelAttribute(){

        $label='<span class="label label-default label-many">Sin definir</span> ';

        if($this->estado=='A'){
            $label='<span class="label label-success label-many">Activo</span> ';
        }elseif($this->estado=='I'){
            $label='<span class="label label-danger label-many">Bloqueado</span> ';
        }

        return $label;
    }

    public function steachers()
    {
        return $this->belongsToMany('App\User::class', 'students_steachers', 'user_est_id', 'user_doc_id');
    }

    public function students()
    {
        return $this->belongsToMany('App\User::class', 'students_steachers', 'id', 'user_est_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }
    public function tipoUsuario()
    {
        return $this->hasOne('App\Core\Entities\Admin\parametro', 'id', 'tipo_id');
    }
    public function pedido()
    {
        return $this->hasMany('App\Core\Entities\Pedido\Pedido', 'asignado_id', 'id');
    }
    

}
