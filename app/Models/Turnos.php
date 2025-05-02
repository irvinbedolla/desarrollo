<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turnos extends Model
{
    //use HasFactory;
    protected $table = 'turnos';
    protected $primaryKey = 'id';
    protected $fillable = ['consecutivo','fecha','hora','hora_fin','auxiliar','solicitante','tipo','lugar_auxiliar','exepcion',
    'edad','sexo','vulnerables','monto','empresa','trabajador','frecuencia','dias','estatus','delegacion','ine','representacion','email','telefono','turnos','JLCA','motivo'];
}
