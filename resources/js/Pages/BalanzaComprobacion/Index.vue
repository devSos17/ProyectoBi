<template>
    <AppLayout>
        <DataTable
            :value="cuentasValores"
            dataKey="id"
            filterDisplay="row"
            :class="`p-datatable-sm`"
        >
            <!-- Definir las columnas -->
            <ColumnGroup type="header">
                <Row >
                    <Column header="Cuenta" :rowspan="2" />
                    <Column header="Balanza de Movimientos" :colspan="2" />
                    <Column header="Balanza de Saldos" :colspan="2" />
                </Row>
                <Row>
                    <Column header="Abonos" style="min-width: 12rem" />
                    <Column header="Retiros" style="min-width: 12rem" />
                    <Column header="Abonos" style="min-width: 12rem" />
                    <Column header="retiros" style="min-width: 12rem" />
                </Row>
            </ColumnGroup>
            <Column field="nombre" style="min-width: 12rem"></Column>
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

            <!-- Texto por defecto en caso de que no exista -->
            <template #empty>Sin Cuentas</template>

            <!-- Totales -->
            <ColumnGroup type="footer">
                <Row>
                    <Column footer="Totales:" footerStyle="text-align:right" />
                    <Column :footer="totalAbonos" />
                    <Column :footer="totalRetiros" />
                    <Column :footer="totalSaldoAbonos" />
                    <Column :footer="totalSaldoRetiros" />
                </Row>
            </ColumnGroup>
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
import ColumnGroup from "primevue/columngroup"; // optional
import Row from "primevue/row";

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

const totalAbonos = computed(() =>
    cuentasValores.value.reduce((acc, val) => acc + val.abonos, 0)
);
const totalRetiros = computed(() =>
    cuentasValores.value.reduce((acc, val) => acc + val.retiros, 0)
);
const totalSaldoAbonos = computed(() =>
    cuentasValores.value
        .filter((val) => val.dif > 0)
        .reduce((acc, val) => acc + val.dif, 0)
);
const totalSaldoRetiros = computed(() =>
    cuentasValores.value
        .filter((val) => val.dif < 0)
        .reduce((acc, val) => acc + -val.dif, 0)
);

// Métodos (Funciones)
// Propiedades (Parámetros [Es arbitrario el nombre])
const props = defineProps(["operaciones", "cuentas"]);

// Filtros de la tabla
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
</script>
