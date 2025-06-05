<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audiencias extends Model
{
    //use HasFactory;
    protected $table = 'audiencias';
    protected $primaryKey = 'id';
    protected $fillable = ['id_solicitud','numero_audiencia','folio_audiencia','fecha','hora','id_conciliador','delegacion','sala'];

    
}
