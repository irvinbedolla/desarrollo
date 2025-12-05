<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeerPerGeneral extends Model
{
    //use HasFactory;
    protected $table = 'seer_general';
    protected $primaryKey = 'id';
    protected $fillable = ['fecha','hora','fecha_conflicto','fecha_confirmacion','NUE','actividad','id_rama','solicitante', 'estado_solicitante', 'mun_solicitante', 
    'user_id','delegacion','conciliador_id', 'curp','tipo','tipo_solicitud','validado_conciliador','estatus','observaciones','fecha_terminacion','documentoExpediente','documentoCitatoriosT','pendiente_firma','caso_excepcion']; 
}
