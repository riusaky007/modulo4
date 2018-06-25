<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    protected $fillable = array('idcliente', 'idtipotelefono','descripcion','marcabaja');
}
