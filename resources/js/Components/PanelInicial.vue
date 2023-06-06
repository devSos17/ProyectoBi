<script setup>
import Card from "primevue/card";
import Button from "primevue/button";
import { Link } from "@inertiajs/vue3";

import { ref } from "vue";

const algo = ref();

algo.value = "Picame we"

</script>

<template>
    <div class="m-auto">
        <div class="grid">
            <div class="col-12 md:col-6">
                <Card>
                    <template #title>
                        <div class="text-center">Registrar Movimiento</div>
                    </template>
                    <template #content>
                        <div class="flex justify-content-center">
                            <Link :href="route('movimiento.index')">
                                <Button label="Ir al modulo" />
                            </Link>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-12 md:col-6">
                <Card>
                    <template #title>
                        <div class="text-center">Balanza de Comprobacion</div>
                    </template>
                    <template #content>
                        <div class="flex justify-content-center">
                            <Link :href="route('balanzacomprobacion.index')">
                                <Button label="Ir al Modulo" />
                            </Link>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-12 md:col-6">
                <Card>
                    <template #title>
                        <div class="text-center">Balance General</div>
                    </template>
                    <template #content>
                        <div class="flex justify-content-center">
                            <Link :href="route('profile.show')">
                                <Button label="Ir al Modulo" />
                            </Link>
                        </div>
                    </template>
                </Card>
            </div>
            <div class="col-12 md:col-6">
                <Card>
                    <template #title>
                        <div class="text-center">Estado de Resultados</div>
                    </template>
                    <template #content>
                        <div class="flex justify-content-center">
                            <Link :href="route('profile.show')">
                                <Button label="Ir al Modulo" />
                            </Link>
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>
