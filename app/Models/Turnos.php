<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turnos extends Model
{
    //use HasFactory;
    protected $table = 'turnos';
    protected $primaryKey = 'id';
    protected $fillable = ['consecutivo','fecha','hora','auxiliar','solicitante','tipo','lugar_auxiliar',
    'estatus','delegacion','exepcion','edad','sexo','vulnerables','conflicto','empresa','trabajador','trabajador_edad','trabajador_sexo'];
}
