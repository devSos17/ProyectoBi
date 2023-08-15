<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;
use Inertia\Inertia;

class BalanceGeneralController extends Controller
{
    public function index()
    {
        $cuentas = Cuenta::with('movimientos')->get();
        return Inertia::render("BalanceGeneral/Index", compact('cuentas'));
    }
}
