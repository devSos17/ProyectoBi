<template>
    <AppLayout>
        <DataTable
            :value="cuentasValores"
            dataKey="id"
            filterDisplay="row"
            :class="`p-datatable-sm`"
        >
            <!-- Texto por defecto en caso de que no exista -->
            <template #empty>Sin Cuentas</template>

            <!-- Definir las columnas -->
            <Column
                field="nombre"
                header="Cuenta"
                style="min-width: 12rem"
            ></Column>
            <Column
                field="abonos"
                header="Abonos"
                style="min-width: 12rem"
            ></Column>
            <Column
                field="retiros"
                header="Retiros"
                style="min-width: 12rem"
            ></Column>
            <Column field="abonos" header="Abonos" style="min-width: 12rem">
            <template #body="{ data }">
                <span v-if="data.dif > 0">{{ data.abonos }}</span>
                </template>
            </Column>
            <Column field="retiros" header="retiros" style="min-width: 12rem">
            <template #body="{ data }">
                <span v-if="data.dif < 0">{{ data.retiros }}</span>
                </template>
            </Column>
        </DataTable>
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

// API para filtrar
import { FilterMatchMode } from "primevue/api";

// Variables
const cuentasValores = computed(() =>
    props.cuentas
        .filter((cuenta) => cuenta.movimientos.length != 0)
        .map((cuenta) => {
            cuenta.abonos = cuenta.movimientos
                .filter((mov) => mov.if_abono)
                .reduce((acc, ite) => acc + ite.cantidad, 0);
            cuenta.retiros = cuenta.movimientos
                .filter((mov) => !mov.if_abono)
                .reduce((acc, ite) => acc + ite.cantidad, 0);
            cuenta.dif = cuenta.abonos - cuenta.retiros;
            return cuenta;
        })
);

// Métodos (Funciones)
// Propiedades (Parámetros [Es arbitrario el nombre])
const props = defineProps(["operaciones", "cuentas"]);

// Filtros de la tabla
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
</script>
