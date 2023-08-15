<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;
use Inertia\Inertia;

class RazonFinancieraController extends Controller
{
    public function index()
    {
        $cuentas = Cuenta::with('movimientos')->get();

        return Inertia::render("RazonesFinancieras/Index", compact('cuentas'));
    }
}
