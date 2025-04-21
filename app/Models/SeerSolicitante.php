<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeerSolicitante extends Model
{
    //use HasFactory;
    protected $table = 'seer_solicitante';
    protected $primaryKey = 'id';
    protected $fillable = ['id_solicitud','tipo_persona','curp','nombre','rfc','sexo','nacionalidad','estado','traductor','lenguaje','fecha_nacimiento',
                           'edad','telefono','email','estado_domicilio','tipo_vialidad','calle','num_ext','num_int','colonia','municipio_domicilio','codigo_postal',
                           'referencia','calle2','calle3','nss','puesto','oficio','pago','periodo_pago','horas_semana','fecha_ingreso','fecha_salida','jornada'];

}
