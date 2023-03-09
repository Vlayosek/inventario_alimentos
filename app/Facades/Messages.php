<?php

namespace App\Facades;

use Alert;

class Messages {

    public function  message($data,$type){
        return session()->flash('alertmanager',compact('data','type'));
    }


    public static function infoRegister($name, $legend){
        $type='success';
        $data="Se ha guardado ".$legend.": ".$name." de forma exitosa!";
        return session()->flash('alertmanager',compact('data','type'));
    }

    public static function warningRegister($name, $legend){
        $type='warning';
        $data=$legend.": ".$name." se actualiza de forma exitosa!";
        return session()->flash('alertmanager',compact('data','type'));
    }

    public static function errorRegister($name, $legend){
        $type='danger';
        $data=$legend.": ".$name." se elimina de forma exitosa!";
        return session()->flash('alertmanager',compact('data','type'));
    }

    public static function errorRegisterCustom( $data){
        $type='danger';
        return session()->flash('alertmanager',compact('data','type'));
    }

    public static function warningRegisterCustom( $data){
        $type='warning';
        return session()->flash('alertmanager',compact('data','type'));
    }

    public static function infoRegisterCustom( $data){
        $type='success';
        return session()->flash('alertmanager',compact('data','type'));
    }

    public function render(){
        if(session('alertmanager')){
            return view()->make('components.alertmanager',session('alertmanager'));
        }
    }
}