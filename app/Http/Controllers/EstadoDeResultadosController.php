<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\EstadoResultados;

class EstadoDeResultadosController extends Controller
{ 
    public function index()
    {
    

        return Inertia::render("EstadoResultados/Index");
    }
}
