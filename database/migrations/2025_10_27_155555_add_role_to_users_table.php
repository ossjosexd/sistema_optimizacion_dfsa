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
        // Le decimos que modifique la tabla 'users'
        Schema::table('users', function (Blueprint $table) {
            // Agregamos la columna 'role' (ej: 'admin', 'user')
            // Por defecto, todos los usuarios nuevos serán 'user' (¡Importante!)
            $table->string('role')->default('user')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Esto es para poder "deshacer" el cambio
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
