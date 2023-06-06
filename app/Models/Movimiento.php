<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        "operacion_id",
        "cuenta_id",
        "cantidad",
        "if_abono"
    ];

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }
    public function operacion()
    {
        return $this->belongsTo(Operacion::class);
    }
}
