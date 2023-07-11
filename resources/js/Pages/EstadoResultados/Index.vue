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
                <template #footer> Utilidad Bruta: $ {{utilidadBrutaTotal}} </template>
            </DataTable>
            <br />
            <DataTable :value="utilidadNeta" tableStyle="min-width: 50rem">
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
                <template #footer> Utilidad Neta: $ {{ utilidadNetaTotal }} </template>
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
        { nombre: "Ventas", monto: sumaCuenta(8) },
        { nombre: "Costos de Venta", monto: sumaCuenta(10)*-1 },
    ];
});

const utilidadBrutaTotal = computed(() => utilidadBruta.value[0].monto - utilidadBruta.value[1].monto)

const utilidadNeta = computed(() => {
    // TODO !IMPORTANT
    // HAY que des-hardcodear estos id's....
    return [
        { nombre: "Utilidad Bruta", monto: utilidadBrutaTotal.value },
        { nombre: "Gastos de Operacion", monto: sumaCuenta(11)*-1 },
    ];
});

const utilidadNetaTotal = computed(() => utilidadNeta.value[0].monto - utilidadNeta.value[1].monto)

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

            console.log({abonos,retiros})
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
