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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id(); // ID único del movimiento

            // Foreign Keys (Claves Foráneas) - Quién y Qué se movió
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Relacionado con la tabla 'products'
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict'); // Quién registró el movimiento
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null'); // Cliente (opcional, para salidas)

            // Detalles del Movimiento
            $table->enum('type', ['entrada', 'salida', 'ajuste_positivo', 'ajuste_negativo']); // Tipo de movimiento
            $table->integer('quantity'); // Cantidad que se movió (siempre positivo)
            $table->date('movement_date'); // Fecha del movimiento
            $table->text('notes')->nullable(); // Notas u observaciones (opcional)

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
