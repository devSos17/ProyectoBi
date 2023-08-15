<template>
    <AppLayout>
        <DataTable 
            :value="operaciones"
            v-model:filters="filters"
            paginator :rows="10"
            dataKey="id"
            filterDisplay="row"
            :globalFilterFields="['concepto', 'fecha']"
            :rowsPerPageOptions="[5, 10, 20, 50]"
            :class="`p-datatable-sm`"
        >
            <!-- Filtro para buscar de manera global -->
            <template #header>
                <div class="flex justify-content-between">
                    <Button class="mr-2 p-button-sm" icon="pi pi-plus" severity="success" label="Nuevo" rounded outlined @click="visible = true"/>
                    <span class="p-input-icon-left">
                        <i class="pi pi-search mr-2"/>
                        <InputText v-model="filters['global'].value" placeholder="Búsqueda..."/>
                    </span>
                </div>
            </template>

            <!-- Texto por defecto en caso de que no exista -->
            <template #empty>Sin movimientos</template>

            <!-- Definir las columnas -->
            <Column field="concepto" header="Concepto" style="min-width: 12rem"></Column>
            
            <Column header="Movimientos" style="min-width: 12rem">
                <template #body="{ data }">
                    <ul class="list-disc" v-for="(movimiento, index) in data.movimientos" :key="index">
                        <li class="mt-1">
                            <b>{{ movimiento.cuenta.nombre }}</b>
                            <br>
                            <span>{{ movimiento.cantidad }} - {{ movimiento.if_abono ? 'Retiro' : 'Abono' }}</span>
                        </li>
                    </ul>
                </template>
            </Column>
            <Column field="fecha" header="Fecha" style="min-width: 12rem">
                <template #body="{ data }">
                    {{ data.fecha }}
                </template>
            </Column>
            <Column header="Procesos" style="min-width: 12rem">
                <template #body="{ data }">
                    <form @submit.prevent="eliminar(data)" method="POST">
                        <Button class="p-button-sm" icon="pi pi-trash" type="submit" severity="danger" rounded outlined/>
                    </form>
                </template>
            </Column>

            <!-- Modales (Dialogs) -->
            <Dialog v-model:visible="visible" modal header="Crear movimiento" :style="{ width: '50vw' }">
                <Divider></Divider>
                <div class="flex justify-content-end">
                    <Button class="mr-2 p-button-sm" icon="pi pi-plus" severity="success" label="Agregar operación" rounded outlined @click="agregarOperacion"/>
                </div>

                <!-- Formulario -->
                <form @submit.prevent="submit" method="POST" class="mt-2">
                    
                    <!-- Sección del movimiento -->
                    <div class="flex justify-content-between mb-2">
                        <div>
                            <label class="font-bold block mb-2">Concepto</label>
                            <InputText v-model="form.concepto" placeholder="Concepto"/>
                        </div>
                    </div>
                    <div>
                        <label class="font-bold block mb-2">Fecha del movimiento</label>
                        <Calendar v-model="form.fecha" />
                    </div>
                    <Divider></Divider>

                    <!-- Ciclo para las operaciones -->
                    <template v-for="(operacion, index) in form.operaciones" :key="index">
                        <div class="flex justify-content-between align-items-center">
                            <div>
                                <label class="font-bold block mb-2">Cuenta</label>
                                <Dropdown
                                    v-model="operacion.selectedTipoCuenta"
                                    :options="cuentas"
                                    filter
                                    optionLabel="nombre"
                                    placeholder="Selecciona una cuenta" 
                                    class="w-full md:w-14rem"
                                >
                                    <template #value="slotProps">
                                        <div v-if="slotProps.value" class="flex align-items-center">
                                            {{ slotProps.value.nombre }}
                                        </div>
                                        <span v-else>
                                            {{ slotProps.placeholder }}
                                        </span>
                                    </template>
                                    <template #option="slotProps">
                                        {{ slotProps.option.nombre }}
                                    </template>
                                </Dropdown>
                            </div>
                            <div>
                                <label class="font-bold block mb-2">Cantidad</label>
                                <InputNumber v-model="operacion.cantidad" inputId="integeronly" locale="es-MX" :minFractionDigits="2" required/>
                            </div>
                            <div class="flex flex-column align-items-center">
                                <label class="font-bold block mb-2">Abono/Retiro</label>
                                <InputSwitch v-model="operacion.abono" />
                            </div>
                            <div class="flex flex-column align-items-center">
                                <Button class="p-button-sm" icon="pi pi-times" text severity="danger" rounded outlined @click="eliminarOperacion(index)"/>
                            </div>
                        </div>
                        <Divider></Divider>
                    </template>

                    <!-- Botones del footer -->
                    <div class="flex justify-content-end mb-2">
                        <Button class="mt-4 mr-2 p-button-sm" severity="primary" label="Validar" rounded outlined @click="validarTotales"/>
                        <Button class="mt-4 mr-2 p-button-sm" severity="help" type="submit" label="Guardar" rounded outlined :disabled="diferenciaAbonoRetiro != 0"/>
                    </div>
                </form>

                <!-- Sección para los totales -->
                <div class="flex justify-content-between">
                    <div>
                        <label class="font-bold block mb-2">Total Abono</label>
                        <InputNumber v-model="totalAbono" disabled/>
                    </div>
                    <div class="mx-2">
                        <label class="font-bold block mb-2">Total Retiro</label>
                        <InputNumber v-model="totalRetiro" disabled/>
                    </div>
                    <div>
                        <label class="font-bold block mb-2">Diferencia</label>
                        <InputNumber v-model="diferenciaAbonoRetiro" disabled/>
                    </div>
                </div>
            </Dialog>
        </DataTable>
    </AppLayout>
</template>

<script setup>
// Vue
import { ref } from 'vue'

// Inertia
import { useForm, router } from '@inertiajs/vue3'

// Componentes del Layout
import AppLayout from "@/Layouts/AppLayout.vue"

// Componentes de PrimeVue
import DataTable from "primevue/datatable"
import Column from "primevue/column"
import InputText from "primevue/inputtext"
import Button from "primevue/button"
import Dialog from "primevue/dialog"
import Dropdown from 'primevue/dropdown'
import InputNumber from 'primevue/inputnumber'
import Divider from 'primevue/divider'
import InputSwitch from 'primevue/inputswitch'
import Calendar from 'primevue/calendar'

// API para filtrar
import { FilterMatchMode } from 'primevue/api'

// Variables
const visible = ref(false)

const form = useForm({
    concepto: null,
    fecha: null,
    operaciones: [
        {
            selectedTipoCuenta: false,
            cantidad: null,
            abono: false,
        }
    ]
})

const diferenciaAbonoRetiro = ref(),
    totalAbono = ref(),
    totalRetiro = ref()

const dataExample = ref([
    { name: 'Amy Elsner', image: 'amyelsner.png' },
    { name: 'Anna Fali', image: 'annafali.png' },
    { name: 'Asiya Javayant', image: 'asiyajavayant.png' },
    { name: 'Bernardo Dominic', image: 'bernardodominic.png' },
    { name: 'Elwin Sharvill', image: 'elwinsharvill.png' },
    { name: 'Ioni Bowcher', image: 'ionibowcher.png' },
    { name: 'Ivan Magalhaes', image: 'ivanmagalhaes.png' },
    { name: 'Onyama Limba', image: 'onyamalimba.png' },
    { name: 'Stephen Shaw', image: 'stephenshaw.png' },
    { name: 'Amy Elsner', image: 'amyelsner.png' },
    { name: 'Anna Fali', image: 'annafali.png' },
    { name: 'Asiya Javayant', image: 'asiyajavayant.png' },
    { name: 'Bernardo Dominic', image: 'bernardodominic.png' },
    { name: 'Elwin Sharvill', image: 'elwinsharvill.png' },
    { name: 'Ioni Bowcher', image: 'ionibowcher.png' },
    { name: 'Ivan Magalhaes', image: 'ivanmagalhaes.png' },
    { name: 'Onyama Limba', image: 'onyamalimba.png' },
    { name: 'Stephen Shaw', image: 'stephenshaw.png' },
    { name: 'Amy Elsner', image: 'amyelsner.png' },
    { name: 'Anna Fali', image: 'annafali.png' },
    { name: 'Asiya Javayant', image: 'asiyajavayant.png' },
    { name: 'Bernardo Dominic', image: 'bernardodominic.png' },
    { name: 'Elwin Sharvill', image: 'elwinsharvill.png' },
    { name: 'Ioni Bowcher', image: 'ionibowcher.png' },
    { name: 'Ivan Magalhaes', image: 'ivanmagalhaes.png' },
    { name: 'Onyama Limba', image: 'onyamalimba.png' },
    { name: 'Stephen Shaw', image: 'stephenshaw.png' },
    { name: 'XuXue Feng', image: 'xuxuefeng.png' }
]);

// Métodos (Funciones)
const agregarOperacion = () => {
    form.operaciones.push({
            selectedTipoCuenta: false,
            cantidad: null,
            abono: false
        })
}

const eliminarOperacion = (index) => {
    form.operaciones.splice(index, 1)
}

const submit = () => {
    form.post(route("movimiento.store"), {
        onSuccess: () => {
            visible.value = false;
        },
        onError: (error) => {
            console.log(error)
        },
    });
}

const eliminar = (event) => {
    router.delete(route('movimiento.destroy', event.id))
}

const validarTotales = () => {
    totalAbono.value = form.operaciones.filter(item => item.abono).reduce((accumulator, item) => {
        return accumulator + item.cantidad
    }, 0)
    totalRetiro.value = form.operaciones.filter(item => !item.abono).reduce((accumulator, item) => {
        return accumulator + item.cantidad
    }, 0)
    diferenciaAbonoRetiro.value = totalAbono.value-totalRetiro.value
}



// Propiedades (Parámetros [Es arbitrario el nombre])
const props = defineProps(['operaciones', 'cuentas'])

// Filtros de la tabla
const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS }
});
</script>