<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operacion extends Model
{
    use HasFactory;

    protected $fillable = [
        "concepto",
        "fecha",
    ];

    public function movimiento()
    {
        return $this->hasMany(Movimiento::class);
    }
}
