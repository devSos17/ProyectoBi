<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{TipoCuenta, Cuenta, Operacion, Movimiento};


class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        TipoCuenta::insert([
            [
                'clase' => 'Activo',
                'subclase' => 'Circulante'
            ],
            [
                'clase' => 'Activo',
                'subclase' => 'Fijo'
            ],
            [
                'clase' => 'Activo',
                'subclase' => 'Diferido'
            ],
            [
                'clase' => 'Pasivo',
                'subclase' => 'Corto plazo'
            ],
            [
                'clase' => 'Pasivo',
                'subclase' => 'Largo plazo'
            ],
            [
                'clase' => 'Pasivo',
                'subclase' => 'Reservas y provisiones'
            ],
            [
                'clase' => 'Capital',
                'subclase' => 'Capital contable'
            ],
            [
                'clase' => 'Ingresos',
                'subclase' => ''
            ],
            [
                'clase' => 'Egresos',
                'subclase' => ''
            ],
            [
                'clase' => 'Eresultados',
                'subclase' => 'Costos'
            ],
            [
                'clase' => 'Eresultados',
                'subclase' => 'Gastos'
            ],
        ]);

        Cuenta::insert([
            ['tipo_cuenta_id' => 1, 'nombre' => 'Banco X'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Cliente Nacionales.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Clientes internacionales.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Deudores diversos.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Documentos x cobrar.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Almacen de Materias primas.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Produccion en proceso.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Almacen de productos terminados.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Almacen de empaque.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Almacen de refacciones.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Materia prima en transito.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Articulos terminados en transito.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Inversiones y valores.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Anticipo a proveedores nacionales.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Anticipo a proveedores internacionales.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'Acciones e Inversiones.'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'IVA acreditable 11%'],
            ['tipo_cuenta_id' => 1, 'nombre' => 'IVA acreditable 16%'],

            ['tipo_cuenta_id' => 2, 'nombre' => 'Terrenos.'],
            ['tipo_cuenta_id' => 2, 'nombre' => 'Edificios.'],
            ['tipo_cuenta_id' => 2, 'nombre' => 'Depreciacion acumulada edificios.'],
            ['tipo_cuenta_id' => 2, 'nombre' => 'Mobiliario y equipo de oficina.'],
            ['tipo_cuenta_id' => 2, 'nombre' => 'Depreciacion acumulada mobiliario y equipo de oficina.'],
            ['tipo_cuenta_id' => 2, 'nombre' => 'Equipo de computo.'],
            ['tipo_cuenta_id' => 2, 'nombre' => 'Depreciacion acumulada equipo de computo.'],
            ['tipo_cuenta_id' => 2, 'nombre' => 'Plantas de proceso.'],
            ['tipo_cuenta_id' => 2, 'nombre' => 'Depreciacion acumulada plantas de proceso.'],
            ['tipo_cuenta_id' => 2, 'nombre' => 'equipo de control ambiental.'],
            ['tipo_cuenta_id' => 2, 'nombre' => 'depreciacion acumulada equipo de control.'],
            ['tipo_cuenta_id' => 2, 'nombre' => 'Equipo de transporte.'],
            ['tipo_cuenta_id' => 2, 'nombre' => 'Depreciacion acumulada equipo de transporte.'],

            ['tipo_cuenta_id' => 3, 'nombre' => 'Rentas pagadas por anticipado.'],
            ['tipo_cuenta_id' => 3, 'nombre' => 'Intereses pagados por anticipado.'],

            ['tipo_cuenta_id' => 4, 'nombre' => 'Cuentas por pagar.'],
            ['tipo_cuenta_id' => 4, 'nombre' => 'Salarios por pagar.'],
            ['tipo_cuenta_id' => 4, 'nombre' => 'Prestaciones por pagar.'],
            ['tipo_cuenta_id' => 4, 'nombre' => 'Proveedores Nacionales.'],
            ['tipo_cuenta_id' => 4, 'nombre' => 'Proveedores Extranjeros.'],
            ['tipo_cuenta_id' => 4, 'nombre' => 'Anticipos de clientes nacionales.'],
            ['tipo_cuenta_id' => 4, 'nombre' => 'Anticipos de clientes extranjeros..'],
            ['tipo_cuenta_id' => 4, 'nombre' => 'Acreedores diversos.'],
            ['tipo_cuenta_id' => 4, 'nombre' => 'Impuestos y derechos por pagar.'],
            ['tipo_cuenta_id' => 4, 'nombre' => 'IVA por pagar 11%'],
            ['tipo_cuenta_id' => 4, 'nombre' => 'IVA por pagar 16%'],

            ['tipo_cuenta_id' => 5, 'nombre' => 'Proveedores Nacionales.'],
            ['tipo_cuenta_id' => 5, 'nombre' => 'Proveedores extranjeros...'],
            ['tipo_cuenta_id' => 5, 'nombre' => 'Pasivo documentado.'],

            ['tipo_cuenta_id' => 6, 'nombre' => 'Reserva para antigüedad.'],
            ['tipo_cuenta_id' => 6, 'nombre' => 'Reserva para indemizaciones.'],
            ['tipo_cuenta_id' => 6, 'nombre' => 'Provision para jubilaciones.'],
            ['tipo_cuenta_id' => 6, 'nombre' => 'Provision para muerte.'],

            ['tipo_cuenta_id' => 7, 'nombre' => 'Capital social.'],
            ['tipo_cuenta_id' => 7, 'nombre' => 'Superavit por revaluacion.'],
            ['tipo_cuenta_id' => 7, 'nombre' => 'Utilidad (perdida) del ejercicio.'],
            ['tipo_cuenta_id' => 7, 'nombre' => 'Utilidad Acumulada.'],

            ['tipo_cuenta_id' => 8, 'nombre' => 'Ventas en el pais.'],
            ['tipo_cuenta_id' => 8, 'nombre' => 'Ventas de exportacion.'],
            ['tipo_cuenta_id' => 8, 'nombre' => 'Productos financieros.'],
            ['tipo_cuenta_id' => 8, 'nombre' => 'Intereses ganados.'],
            ['tipo_cuenta_id' => 8, 'nombre' => 'Rendimientos'],
            ['tipo_cuenta_id' => 8, 'nombre' => 'Utilidad Cambiaria.'],
            ['tipo_cuenta_id' => 8, 'nombre' => 'Otros Ingresos.'],

            ['tipo_cuenta_id' => 9, 'nombre' => 'Sueldos y salarios.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Vida cara.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Ropa de trabajo.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Manejo de vehiculo.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Tiempo extraordinario.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Fondo de ahorro.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Comedor.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Despensa.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Premios por asistencia y puntualidad.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Incentivos al desempeño.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Premios por productividad.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Prima Vacacional.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Aguinaldo Anual.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Becas.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Cuotas deportivas.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Teatros.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Pagos por servicios medicos.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Otros gastos de prevision social.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Reserva para indemnizaciones a trabajadores.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Reserva para antigüedad.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Reserva para indemnizaciones'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Reserva para jubilaciones.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Reserva para muerte.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Cuotas IMSS, enfermedades y maternidad.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Cuotas IMSS, invalidez y vida.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Cuotas IMSS, cesantia en edad avanzada y vejez.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Cuota IMSS, riesgo de trabajo.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Cuota IMSS, retiro.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Cuota IMMS, guarderias y prestaciones sociales.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Cuota Infonavit.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Impuestos Especiales.'],
            ['tipo_cuenta_id' => 9, 'nombre' => 'Depreciacion de  edificios.'],

            ['tipo_cuenta_id' => 10, 'nombre' => 'Costos de Venta'],

            ['tipo_cuenta_id' => 11, 'nombre' => 'Gastos Operativos'],
            ['tipo_cuenta_id' => 11, 'nombre' => 'Gastos Administrativos']
        ]);
    }
}
