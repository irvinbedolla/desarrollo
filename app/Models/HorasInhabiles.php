<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiasInhabiles extends Model
{
    //use HasFactory;
    protected $table = 'horasinhabiles';
    protected $primaryKey = 'id';
    protected $fillable = ['id_usuario','delegacion','fecha_inicio','fecha_final','hora_inicio','hola_final'];

}
