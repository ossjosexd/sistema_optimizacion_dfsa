<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'numeracion', 
        'descripcion', 
        'modelo', 
        'cantidad', 
        'largo', 
        'ancho', 
        'unidad_medida', 
        'stock_minimo',
        'fecha',
        'ficha_fabricante', 
    ];

    protected $casts = [
        'stock_minimo' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        // Asigna el ID a la numeración automáticamente al crear
        static::created(function ($producto) {
            $producto->numeracion = $producto->id; 
            $producto->saveQuietly(); 
        });
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }
}