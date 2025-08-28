<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poder extends Model
{
    //use HasFactory;
    protected $table = 'abogados';
    protected $primaryKey = 'idAbogado';
    protected $fillable = ['nombres', 'primer_apellido','segundo_apellido','telefono','email', 'ine', 'cedula', 'anexo', 'representacion', 'fechaRegistro', 'fechaVigencia', 
                            'empresa', 'eliminado', 'curp', 'estado_poder', 'municipio_poder', 'vialidadPoder', 'vialidad_callePoder', 'coloniaAbogadoAlta', 'NExtAbogadoAlta',
                            'NIntAbogadoAlta', 'cpAbogadoAlta', 'rfc', 'industria', 'poder', 'regionMorelia', 'regionUruapan', 'regionZamora','estatus','tipo'];
}
