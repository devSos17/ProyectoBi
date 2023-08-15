<template>
    <AppLayout>
        <span>Capital neto de trabajo: {{ capital_neto_trabajo.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }) }}</span>
        <br>
        <span>Capital neto de trabajo disponible: {{ capital_neto_trabajo_disponible.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }) }}</span>
        <br>
        <span>Razón circulante: {{ razon_de_circulante.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }) }}</span>
        <br>
        <span>Razón acida: {{ razon_acida.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }) }}</span>
        <br>
    </AppLayout>
</template>

<script setup>

import { ref, computed } from 'vue'

import AppLayout from "@/Layouts/AppLayout.vue"

const props = defineProps(["cuentas"]);

// Totales
const total_activo_circulante = computed(() => total_cuentas(1))
const total_pasivo_corto_plazo = computed(() => total_cuentas(4))
const total_inventario      = computed(() => {
    const pan = [6, 8, 9, 10]

    return props.cuentas
        .filter(cuenta => pan.includes(cuenta.id))
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
})

console.log(total_inventario.value)

const capital_neto_trabajo = computed(() => total_activo_circulante.value - total_pasivo_corto_plazo.value),
      capital_neto_trabajo_disponible = computed(() => (total_activo_circulante.value - total_inventario.value) - total_pasivo_corto_plazo.value),
      razon_de_circulante = computed(() => total_activo_circulante.value / total_pasivo_corto_plazo.value),
      razon_acida = computed(() => (total_activo_circulante.value-total_inventario.value) / total_pasivo_corto_plazo.value)

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

</script>