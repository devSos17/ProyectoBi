<script setup>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import AppLayout from "@/Layouts/AppLayout.vue"
import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row';                   // optional

</script>



<template>
    <AppLayout>
        <div>
            <DataTable :value="products" tableStyle="min-width: 50rem">
                <template #header>
                    <div class="flex flex-wrap align-items-center justify-content-between gap-2">
                        <span class="text-xl text-900 font-bold">Estado de Resultados</span>
                        <Button icon="pi pi-refresh" rounded raised />
                    </div>
                    <div class="flex flex-wrap align-items-center justify-content-between gap-2">
                        <Button icon="pi pi-refresh" rounded raised />
                    </div>
                </template>
                <Column field="name" header="Categoría"></Column>
                <Column field="price" header="Cantidad">
                    <template #body="slotProps">
                        {{ formatCurrency(slotProps.data.price) }}
                    </template>
                </Column>
                <template #footer> In total there are {{ products ? products.length : 0 }} products. </template>
            </DataTable>
        </div>
    </AppLayout>
</template>