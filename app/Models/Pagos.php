<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    //use HasFactory;
    protected $table = 'pago_solicitud';
    protected $primaryKey = 'id';
    protected $fillable = ['id_solicitud','fecha','hora','monto','descripcion','observaciones','estatus','tipo_pago'];
    
}