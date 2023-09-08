<template>
    <AppLayout title="Estado de Resultados">
        <template #header>
            <h1>Estado de Resultados</h1>
        </template>
        <div>
            <DataTable :value="utilidadBruta" tableStyle="min-width: 50rem">
                <template #header>
                    <div
                        class="flex flex-wrap align-items-center justify-content-between gap-2"
                    >
                        <h1>Estado de Resultados - Boliman</h1>
                    </div>
                </template>
                <Column field="nombre" header="Concepto"></Column>
                <Column field="monto" header="Monto">
                    <template #body="{ data }">
                        $
                        {{
                            data.monto > 0
                                ? `${data.monto}`
                                : `(${data.monto * -1})`
                        }}
                    </template>
                </Column>
                <template #footer>
                    Utilidad Bruta: $ {{ utilidadBrutaTotal }}
                </template>
            </DataTable>
            <br />
            <DataTable :value="utilidadOperacion" tableStyle="min-width: 50rem">
                <Column field="nombre" header="Concepto"></Column>
                <Column field="monto" header="Monto">
                    <template #body="{ data }">
                        $
                        {{
                            data.monto > 0
                                ? `${data.monto}`
                                : `(${data.monto * -1})`
                        }}
                    </template>
                </Column>
                <template #footer>
                    Utilidad de Operacion: $ {{ utilidadOperacionTotal }}
                </template>
            </DataTable>
            <br />
            <DataTable
                :value="utilidadAntesImpuestos"
                tableStyle="min-width: 50rem"
            >
                <Column field="nombre" header="Concepto"></Column>
                <Column field="monto" header="Monto">
                    <template #body="{ data }">
                        $
                        {{
                            data.monto > 0
                                ? `${data.monto}`
                                : `(${data.monto * -1})`
                        }}
                    </template>
                </Column>
                <template #footer>
                    Utilidad antes de PTU e ISR: $
                    {{ utilidadAntesImpuestosTotal }}
                </template>
            </DataTable>
            <br />
            <DataTable
                :value="utilidadEjercicio"
                tableStyle="min-width: 50rem"
            >
                <Column field="nombre" header="Concepto"></Column>
                <Column field="monto" header="Monto">
                    <template #body="{ data }">
                        $
                        {{
                            data.monto > 0
                                ? `${data.monto}`
                                : `(${data.monto * -1})`
                        }}
                    </template>
                </Column>
                <template #footer>
                    Utilidad del Ejercicio: $
                    {{ utilidadEjercicioTotal }}
                </template>
            </DataTable>
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

// API para filtrar
import { FilterMatchMode } from "primevue/api";

// Variables
const utilidadBruta = computed(() => {
    // TODO !IMPORTANT
    // HAY que des-hardcodear estos id's....
    return [
        // Hardcodeado para press
        // { nombre: "Ventas", monto: sumaCuenta(8) },
        { nombre: "Ventas", monto: 210000 },
        // Hardcodeado del Estado de Costos...
        { nombre: "Costos de Venta", monto: 100800 },
    ];
});

const utilidadBrutaTotal = computed(
    () => utilidadBruta.value[0].monto - utilidadBruta.value[1].monto
);

const utilidadOperacion = computed(() => {
    // TODO !IMPORTANT
    // HAY que des-hardcodear estos id's....
    return [
        { nombre: "Utilidad Bruta", monto: utilidadBrutaTotal.value },
        // { nombre: "Gastos de Operacion", monto: sumaCuenta(11)*-1 },
        // Hardcodeado para press
        { nombre: "Gastos de Operacion", monto: 0 },
        { nombre: "Gastos de Administracion", monto: -12400 },
        { nombre: "Gastos de Ventas", monto: -15100 },
    ];
});

// const utilidadOperacionTotal = computed(() => utilidadOperacion.value[0].monto + utilidadOperacion.value[1].monto - utilidadOperacion.value[2].monto - utilidadOperacion.value[3].monto )
const utilidadOperacionTotal = computed(() =>
    utilidadOperacion.value.reduce((arr, ite) => arr + ite.monto, 0)
);

const utilidadAntesImpuestos = computed(() => {
    // TODO !IMPORTANT
    // HAY que des-hardcodear estos id's....
    return [
        {
            nombre: "Utilidad de Operacion",
            monto: utilidadOperacionTotal.value,
        },
        // { nombre: "Gastos de Operacion", monto: sumaCuenta(11)*-1 },
        // Hardcodeado para press
        { nombre: "Otros Ingresos", monto: 0 },
        { nombre: "Otros Gastos", monto: 0 },
    ];
});

const utilidadAntesImpuestosTotal = computed(() =>
    utilidadAntesImpuestos.value.reduce((arr, ite) => arr + ite.monto, 0)
);

// Impuestos
let PTU = 0.3,
    ISR = 0.1;
const utilidadEjercicio = computed(() => {
    // TODO !IMPORTANT
    // HAY que des-hardcodear estos id's....
    return [
        {
            nombre: "Utilidad antes de PTU e ISR",
            monto: utilidadAntesImpuestosTotal.value,
        },
        // { nombre: "Gastos de Operacion", monto: sumaCuenta(11)*-1 },
        { nombre: "PTU", monto: -(utilidadAntesImpuestosTotal.value * PTU) },
        { nombre: "ISR", monto: -(utilidadAntesImpuestosTotal.value * ISR) },
    ];
});

const utilidadEjercicioTotal = computed(() =>
    utilidadEjercicio.value.reduce((arr, ite) => arr + ite.monto, 0)
);

const sumaCuenta = (tipoId) =>
    props.cuentas
        .filter((cuenta) => cuenta.tipo_cuenta_id == tipoId)
        .filter((cuenta) => cuenta.movimientos.length > 0)
        .map((cuenta) => {
            let abonos = cuenta.movimientos
                .filter((mov) => mov.if_abono)
                .reduce((acc, ite) => acc + ite.cantidad, 0);
            let retiros = cuenta.movimientos
                .filter((mov) => !mov.if_abono)
                .reduce((acc, ite) => acc + ite.cantidad, 0);

            console.log({ abonos, retiros });
            return abonos - retiros;
        })
        .reduce((acc, ite) => acc + ite, 0);
// Métodos (Funciones)
// Propiedades (Parámetros [Es arbitrario el nombre])
const props = defineProps(["cuentas"]);

// Filtros de la tabla
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
</script>
