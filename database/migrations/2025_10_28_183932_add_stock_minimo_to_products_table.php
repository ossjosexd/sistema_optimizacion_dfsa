<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Agrega la columna stock_minimo a la tabla products.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Agregamos la columna para el stock mínimo
            // Usamos decimal para permitir mínimos con decimales (ej: 0.5 m2)
            // Es nullable y default 0 para productos existentes o que no requieran mínimo.
            $table->decimal('stock_minimo', 10, 2)->nullable()->default(0.00)->after('unidad_medida');
        });
    }

    /**
     * Reverse the migrations.
     * Elimina la columna si hacemos rollback.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Verifica si la columna existe antes de intentar eliminarla
            if (Schema::hasColumn('products', 'stock_minimo')) {
                $table->dropColumn('stock_minimo');
            }
        });
    }
};
