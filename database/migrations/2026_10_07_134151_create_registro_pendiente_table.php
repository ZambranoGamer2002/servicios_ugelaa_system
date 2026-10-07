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
        Schema::create('registro_pendiente', function (Blueprint $table) {
            $table->id();
            $table->string('dni')->nullable();
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('nombre_completo')->nullable();
            $table->string('correo')->nullable();
            $table->string('nickname')->nullable();
            $table->string('password')->nullable();
            $table->string('token')->nullable();
            $table->timestamp('expira_en')->nullable();
            $table->boolean('verificado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_pendiente');
    }
};
