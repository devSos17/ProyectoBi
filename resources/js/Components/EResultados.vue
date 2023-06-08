<script setup>
import Card from "primevue/card";
import Button from "primevue/button";
</script>

<template>
    <div class="m-auto">
        <div class="col-12 md:col-6">
                <Card>
                    <template #title>
                        <div class="text-center">Registrar Movimiento</div>
                    </template>
                    <template #content>
                        <div class="flex justify-content-center">
                            <Link :href="route('profile.show')">
                                <Button label="Ir al modulo" />
                            </Link>
                        </div>
                    </template>
                </Card>
            </div>
    </div>
</template>