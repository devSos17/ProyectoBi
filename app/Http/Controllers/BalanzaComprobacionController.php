<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\{TipoCuenta, Cuenta, Operacion, Movimiento};

class BalanzaComprobacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuentas = Cuenta::with('movimientos')->get();
        return Inertia::render("BalanzaComprobacion/Index", compact('cuentas'));
    }

}
