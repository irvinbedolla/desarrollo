<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeerCasosExcepcion extends Model
{
    //use HasFactory;
    protected $table = 'seer_casos_excepcion';
    protected $primaryKey = 'id';
    protected $fillable = ['id_turno','id_user','observaciones','dependencia', 'expediente','fecha','hora','created_at','updated_at'];
}
