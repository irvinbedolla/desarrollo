<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencia_conferencias';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_asistente',
        'conferencia1',
        'conferencia2',
        'conferencia3',
        'conferencia4',
        'conferencia5',
        'conferencia6',
        'conferencia7',
        'conferencia8',
        'conferencia9',
        'conferencia10',
    ];

    protected $casts = [
        'conferencia1' => 'boolean',
        'conferencia2' => 'boolean',
        'conferencia3' => 'boolean',
        'conferencia4' => 'boolean',
        'conferencia5' => 'boolean',
        'conferencia6' => 'boolean',
        'conferencia7' => 'boolean',
        'conferencia8' => 'boolean',
        'conferencia9' => 'boolean',
        'conferencia10' => 'boolean',
    ];
    

    public function attendee()
    {
        return $this->belongsTo(TercerEncuentro::class, 'id_asistente');
    }
}