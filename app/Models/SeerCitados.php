<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeerCitados extends Model
{
    //use HasFactory;
    protected $table = 'seer_citados';
    protected $primaryKey = 'id';
    protected $fillable = ['id_solicitud','tipo_persona','curp','rfc','nombre','primer_apellido','segundo_apellido','fecha_nacimiento','edad','sexo','nacionalidad','estado_solicitante','traductor','lenguaje','tipo_notificacion','id_notificador','notificacion',
    'colonia','cp','calle1','calle2','n_ext','n_int','estatus','calle','tipo_vialidad','referencia','documento','observaciones','id_abogado']; 
}