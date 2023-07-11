<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Cuenta;

class EstadoDeResultadosController extends Controller
{
    public function index()
    {

        $cuentas = Cuenta::with('movimientos')->get();
        return Inertia::render("EstadoResultados/Index", compact('cuentas'));
    }
}
