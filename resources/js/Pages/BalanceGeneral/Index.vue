<template>
    <AppLayout title="Estado de Resultados">
        <template #header>
            <h1>Estado de Resultados</h1>
        </template>
        <div>
            <DataTable :value="activo_circulante" tableStyle="min-width: 50rem">
                <template #header>
                    <div
                        class="flex flex-wrap align-items-center justify-content-between gap-2"
                    >
                        <h1>Activo circulante</h1>
                    </div>
                </template>
                <Column field="nombre" header="Concepto"></Column>
                <Column field="monto" header="Monto"></Column>
                <template #footer>Total: $ {{total_activo_circulante}} </template>
            </DataTable>

            <!-- Fijo -->

            <DataTable :value="activo_fijo" tableStyle="min-width: 50rem">
                <template #header>
                    <div
                        class="flex flex-wrap align-items-center justify-content-between gap-2"
                    >
                        <h1>Activo fijo</h1>
                    </div>
                </template>
                <Column field="nombre" header="Concepto"></Column>
                <Column field="monto" header="Monto"></Column>
                <template #footer>Total: $ {{total_activo_fijo}} </template>
            </DataTable>

            <!-- Diferido -->
            <DataTable :value="activo_diferido" tableStyle="min-width: 50rem">
                <template #header>
                    <div
                        class="flex flex-wrap align-items-center justify-content-between gap-2"
                    >
                        <h1>Activo diferido</h1>
                    </div>
                </template>
                <Column field="nombre" header="Concepto"></Column>
                <Column field="monto" header="Monto"></Column>
                <template #footer>Total: $ {{total_activo_diferido}} </template>
            </DataTable>

            <!-- Pasivo -->
            <DataTable :value="pasivo_corto_plazo" tableStyle="min-width: 50rem">
                <template #header>
                    <div
                        class="flex flex-wrap align-items-center justify-content-between gap-2"
                    >
                        <h1>Pasivo</h1>
                    </div>
                </template>
                <Column field="nombre" header="Concepto"></Column>
                <Column field="monto" header="Monto">
                    <template #body="{ data }">
                        ${{ data.monto*-1 }}
                    </template>
                </Column>
                <template #footer>Total: $ {{total_pasivo_corto_plazo*-1}} </template>
            </DataTable>

            <!-- Capital -->
            <DataTable :value="capital" tableStyle="min-width: 50rem">
                <template #header>
                    <div
                        class="flex flex-wrap align-items-center justify-content-between gap-2"
                    >
                        <h1>Capital</h1>
                    </div>
                </template>
                <Column field="nombre" header="Concepto"></Column>
                <Column field="monto" header="Monto">
                    <template #body="{ data }">
                        ${{ data.monto*-1 }}
                    </template>
                </Column>
                <template #footer>Total: $ {{total_capital*-1 + 2700}} </template>
            </DataTable>

            <h1>
                Total Activo: {{ total_activo_circulante + total_activo_fijo + total_activo_diferido }}
                Total Pasivo + Capital: {{ (total_pasivo_corto_plazo + total_capital)*-1 + 2700 }}
            </h1>
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

// Métodos
const cuentas = (tipoId) => {
    return props.cuentas
        .filter((cuenta) => cuenta.tipo_cuenta_id == tipoId)
        .filter((cuenta) => cuenta.movimientos.length > 0)
        .map((cuenta) => {
            let abonos = cuenta.movimientos
                .filter((mov) => !mov.if_abono)
                .reduce((acc, ite) => acc + ite.cantidad, 0);
            let retiros = cuenta.movimientos
                .filter((mov) => mov.if_abono)
                .reduce((acc, ite) => acc + ite.cantidad, 0);
            return {...cuenta, monto: abonos - retiros};
        })
}

const total_cuentas = (tipoId) => {
    return props.cuentas
        .filter((cuenta) => cuenta.tipo_cuenta_id == tipoId)
        .filter((cuenta) => cuenta.movimientos.length > 0)
        .map((cuenta) => {
            let abonos = cuenta.movimientos
                .filter((mov) => !mov.if_abono)
                .reduce((acc, ite) => acc + ite.cantidad, 0);
            let retiros = cuenta.movimientos
                .filter((mov) => mov.if_abono)
                .reduce((acc, ite) => acc + ite.cantidad, 0);
            return {...cuenta, monto: abonos - retiros};
        })
        .reduce((acc, ite) => acc + ite.monto, 0)
}

// Activos
const activo_circulante = computed(() => cuentas(1))

const activo_fijo = computed(() => cuentas(2))
const activo_diferido = computed(() => cuentas(3))

// Pasivos
const pasivo_corto_plazo = computed(() => cuentas(4))

// Capital
const capital = computed(() => [...cuentas(7), {nombre: "Utilidad del ejercicio: ", monto: 2700*-1}])
capital.value = [...capital.value, {nombre: "Utilidad del ejercicio: ", monto: 2700}]



// Totales

const total_activo_circulante = computed(() => total_cuentas(1))
const total_activo_fijo = computed(() => total_cuentas(2))
const total_activo_diferido = computed(() => total_cuentas(3))

const total_pasivo_corto_plazo = computed(() => total_cuentas(4))

const total_capital = computed(() => total_cuentas(7))


// Métodos (Funciones)
// Propiedades (Parámetros [Es arbitrario el nombre])
const props = defineProps(["cuentas"]);

// Filtros de la tabla
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
</script>
