<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\{TipoCuenta, Cuenta, Operacion, Movimiento};
use Carbon\Carbon;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operaciones = Operacion::with(['movimientos.cuenta'])->get();
        $cuentas = Cuenta::get();

        return Inertia::render("Movimiento/Index", compact('operaciones', 'cuentas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $operacion = Operacion::create([
            'concepto' => $request->concepto,
            'fecha' => Carbon::parse($request->fecha)->format("Y-m-d H:m:s")
        ]);

        foreach($request->operaciones as $movimiento){
            
            Movimiento::create([
                'cuenta_id' => $movimiento['selectedTipoCuenta']['id'],
                'operacion_id' => $operacion->id,
                'cantidad' => $movimiento['cantidad'],
                'if_abono' => $movimiento['abono']
            ]);
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Movimiento $movimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movimiento $movimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movimiento $movimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        $operacion = Operacion::find($id);

        $operacion->delete();
    }
}
