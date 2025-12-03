<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audiencias extends Model
{ 
    use HasFactory;

    protected $table = 'audiencias';
    protected $primaryKey = 'id';
    protected $fillable = ['id_solicitud','numero_audiencia','folio_audiencia', 'estatus', 'tipo', 'fecha','hora','id_conciliador','delegacion','sala', 'estatus'];

    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime:H:i'
    ];

    public const ESTADOS = ['Conciliación', 'No Conciliación', 'Archivada', 'Incompetencia'];
    public const TIPOS = ['Pago Parcial', 'Pago Total'];
}
