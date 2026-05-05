<script setup>
import CPLayout from '@/Layouts/CPLayout.vue';
import { Head } from '@inertiajs/vue3';
import Card from 'primevue/card';

defineOptions({ layout: CPLayout });
</script>

<template>
    <Head title="Dashboard CP" />
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <Card class="bg-white">
            <template #title>Projets Actifs</template>
            <template #content><p class="text-4xl font-bold text-emerald-600">12</p></template>
        </Card>
        <!-- Autres cartes de stats ici -->
    </div>
</template>