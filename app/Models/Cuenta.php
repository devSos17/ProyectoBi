<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function tipoCuenta()
    {
        return $this->belongsTo(TipoCuenta::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }
}
