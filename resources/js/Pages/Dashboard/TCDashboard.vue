<script setup>
import TCLayout from '@/Layouts/TCLayout.vue';
import { Head } from '@inertiajs/vue3';
import Timeline from 'primevue/timeline';

defineOptions({ layout: TCLayout });

const events = [
    { status: 'Tâche A', date: '09:00', icon: 'pi pi-shopping-cart', color: '#9C27B0'},
    { status: 'Tâche B', date: '11:00', icon: 'pi pi-cog', color: '#673AB7'},
];
</script>

<template>
    <Head title="Mes Tâches" />
    <div class="max-w-lg mx-auto">
        <h2 class="mb-4 font-medium text-gray-700">Mon planning du jour</h2>
        <Timeline :value="events">
            <template #content="slotProps">
                {{ slotProps.item.status }} ({{ slotProps.item.date }})
            </template>
        </Timeline>
    </div>
</template>
