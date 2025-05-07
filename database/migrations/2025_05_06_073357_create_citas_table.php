<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->longText('motivo');
            $table->date('fecha');
            $table->time('hora');
            $table->integer('usuario');
            $table->enum('estatus', ['pendiente', 'confirmada', 'cancelada']);
            $table->enum('tipo', ['solicitud', 'ratificacion']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
