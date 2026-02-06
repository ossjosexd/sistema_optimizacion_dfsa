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
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // ID automático

            $table->string('rif')->unique();         // RIF del cliente (único)
            $table->string('nombre_empresa');      // Nombre de la empresa
            $table->string('persona_contacto')->nullable(); // Nombre de la persona (opcional)
            $table->string('telefono')->nullable();       // Teléfono (opcional)
            $table->string('email')->nullable()->unique(); // Email (opcional y único)
            $table->text('direccion')->nullable();       // Dirección (opcional)

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
