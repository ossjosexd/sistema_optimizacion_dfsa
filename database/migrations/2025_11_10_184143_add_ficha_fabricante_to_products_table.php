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
        Schema::table('products', function (Blueprint $table) {
            // Añade la nueva columna para la URL o el nombre del archivo
            $table->string('ficha_fabricante', 255)->nullable()->after('stock_minimo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Elimina la columna si se revierte la migración
            $table->dropColumn('ficha_fabricante');
        });
    }
};
