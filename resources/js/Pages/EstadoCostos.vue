<template>
    <AppLayout title="Estado de Resultados">
        <template #header>
            <h1>Estado de Resultados</h1>
        </template>
        <div>
            <DataTable :value="computedData" tableStyle="min-width: 50rem">
                <template #header>
                    <div
                        class="flex flex-wrap align-items-center justify-content-between gap-2"
                    >
                        <h1>Estado de Resultados - Boliman</h1>
                    </div>
                </template>
                <Column field="nombre" header="Concepto"></Column>
                <Column field="desgloce" header="">
                    <template #body="{ data }">
                        <div v-if="data?.desgloce">
                            $
                            {{
                                data.desgloce > 0
                                    ? `${data.desgloce}`
                                    : `(${data.desgloce * -1})`
                            }}
                        </div>
                    </template>
                </Column>
                <Column field="monto" header="Monto">
                    <template #body="{ data }">
                        <div v-if="data?.monto">
                            $
                            {{
                                data.monto > 0
                                    ? `${data.monto}`
                                    : `(${data.monto * -1})`
                            }}
                        </div>
                    </template>
                </Column>
                <template #footer> Costo de los productos Venidos: $ {{ costoProductosVendidos }} </template>
            </DataTable>
            <br />
        </div>
    </AppLayout>
</template>

<script setup>
// Vue
import { ref, computed } from "vue";

// Componentes del Layout
import AppLayout from "@/Layouts/AppLayout.vue";

// Componentes de PrimeVue
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup"; // optional
import Row from "primevue/row";

const computedData = computed(() => data);
let data = [
    {
        nombre: "Inventario Inicial de materias primas",
        monto: 17500,
    },
    {
        nombre: "Costo de Materias primas Recibidas",
        monto: 28000,
    },
    {
        nombre: "Inverntario final de materias",
        monto: -12600,
    },
    {
        nombre: "Total de materias primas utilizadas",
        monto: 32900,
    },
    {
        nombre: "Costo de materias primas indirectas utilizadas",
        monto: -4900,
    },
    {
        nombre: "Costo de materias primas directas",
        monto: 28000,
    },
    {
        nombre: "Mano de obra directa utilizada",
        monto: 10500,
    },
    {
        nombre: "Total mano de obra",
        desgloce: 12600,
    },
    {
        nombre: "Mano de obra indirecta",
        desgloce: -2100,
    },
    {
        nombre: "Costo Primo",
        monto: 11900,
    },
    {
        nombre: "Cargos indirectos",
        desgloce: 4900,
    },
    {
        nombre: "Mano de obra indirecta",
        desgloce: 2100,
    },
    {
        nombre: "Diversas erogaciones fabriles",
        desgloce: 1400,
    },
    {
        nombre: "Depreciacion Acumulada",
        desgloce: 3500,
    },
    {
        nombre: "Amortizaciones fabriles",
        desgloce: 0,
    },
    {
        nombre: "Costo de produccion procesada",
        monto: 50400,
    },
    {
        nombre: "Inventario Inicial de prododuccion en proceso",
        monto: 11900,
    },
    {
        nombre: "Produccion en proceso disponible",
        monto: 62300,
    },
    {
        nombre: "Inventario final de produccion en proceso",
        monto: -16800,
    },
    {
        nombre: "Costo de produccion terminada",
        monto: 45500,
    },
    {
        nombre: "Inventario inicial de producto terminado",
        monto: 21000,
    },
    {
        nombre: "Productos terminados en disponibilidad",
        monto: 66500,
    },
    {
        nombre: "Inventario final de producto terminado",
        monto: -24500,
    },
];

const costoProductosVendidos = ref(42000)

// API para filtrar
// import { FilterMatchMode } from "primevue/api";
//
// // Variables
// const utilidadBruta = computed(() => {
//     // TODO !IMPORTANT
//     // HAY que des-hardcodear estos id's....
//     return [
//         { nombre: "Ventas", monto: sumaCuenta(8) },
//         { nombre: "Costos de Venta", monto: sumaCuenta(10)*-1 },
//     ];
// });
//
// const utilidadBrutaTotal = computed(() => utilidadBruta.value[0].monto - utilidadBruta.value[1].monto)
//
// const utilidadNeta = computed(() => {
//     // TODO !IMPORTANT
//     // HAY que des-hardcodear estos id's....
//     return [
//         { nombre: "Utilidad Bruta", monto: utilidadBrutaTotal.value },
//         { nombre: "Gastos de Operacion", monto: sumaCuenta(11)*-1 },
//     ];
// });
//
// const utilidadNetaTotal = computed(() => utilidadNeta.value[0].monto - utilidadNeta.value[1].monto)
//
// const sumaCuenta = (tipoId) =>
//     props.cuentas
//         .filter((cuenta) => cuenta.tipo_cuenta_id == tipoId)
//         .filter((cuenta) => cuenta.movimientos.length > 0)
//         .map((cuenta) => {
//             let abonos = cuenta.movimientos
//                 .filter((mov) => mov.if_abono)
//                 .reduce((acc, ite) => acc + ite.cantidad, 0);
//             let retiros = cuenta.movimientos
//                 .filter((mov) => !mov.if_abono)
//                 .reduce((acc, ite) => acc + ite.cantidad, 0);
//
//             console.log({abonos,retiros})
//             return abonos - retiros;
//         })
//         .reduce((acc, ite) => acc + ite, 0);
// // Métodos (Funciones)
// // Propiedades (Parámetros [Es arbitrario el nombre])
// const props = defineProps(["cuentas"]);
//
// // Filtros de la tabla
// const filters = ref({
//     global: { value: null, matchMode: FilterMatchMode.CONTAINS },
// });
</script>
