<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiasInhabiles extends Model
{
    //use HasFactory;
    protected $table = 'diasinhabiles';
    protected $primaryKey = 'id';
    protected $fillable = ['fecha_inical','fecha_final', 'delegacion'];

}
