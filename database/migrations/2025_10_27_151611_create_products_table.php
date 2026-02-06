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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // ID automático (1, 2, 3...)
            
            $table->string('numeracion')->unique(); // El código (Ej: BND-001) y único
            $table->string('descripcion');          // Nombre o Descripción
            $table->string('modelo')->nullable();   // Modelo (opcional)
            $table->integer('cantidad')->default(0); // Cantidad (número entero)
            
            // Usamos decimal para 'largo' y 'ancho' para permitir 10.5, 1.2, etc.
            // 'nullable()' significa que puede estar vacío (para 'unid.')
            $table->decimal('largo', 8, 2)->nullable(); // 8 dígitos totales, 2 decimales
            $table->decimal('ancho', 8, 2)->nullable();
            
            $table->string('unidad_medida'); // 'm2' o 'unid'
            $table->date('fecha');          // Fecha de ingreso

            $table->timestamps(); // Crea 'created_at' y 'updated_at' (¡súper útil!)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
