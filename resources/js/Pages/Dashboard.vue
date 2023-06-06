<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PanelInicial from '@/Components/PanelInicial.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Menu Pricipal
            </h2>
        </template>

        <div class="py-12 px-12">
            <PanelInicial />
        </div>
    </AppLayout>
</template>
