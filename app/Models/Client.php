<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_empresa',
        'rif',
        'persona_contacto', 
        'direccion',
        'telefono',
        'email',          
    ];
    
    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
}
