<script setup>
import SUPLayout from '@/Layouts/SUPLayout.vue';
import { Head } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';

defineOptions({ layout: SUPLayout });
defineProps({ pending_tasks: Array }); // Données envoyées par le controller
</script>

<template>
    <Head title="Validation Superviseur" />
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Tâches en attente de validation</h2>
        <DataTable :value="pending_tasks" responsiveLayout="scroll">
            <Column field="name" header="Tâche"></Column>
            <Column field="assignee" header="Assigné à"></Column>
            <Column header="Action">
                <template #body>
                    <Button label="Valider" class="p-button-success p-button-sm" />
                </template>
            </Column>
        </DataTable>
    </div>
</template>