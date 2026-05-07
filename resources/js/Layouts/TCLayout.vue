<script setup>
import { watch } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const page = usePage();
const toast = useToast();

// Surveiller les messages flash
watch(
    () => page.props.flash,
    (flash) => {
        if (flash?.success) {
            toast.add({ severity: 'success', summary: 'Succès', detail: flash.success, life: 4000 });
        }
        if (flash?.error) {
            toast.add({ severity: 'error', summary: 'Erreur', detail: flash.error, life: 4000 });
        }
    },
    { deep: true, immediate: true }
);
</script>

<template>
    <Toast position="top-center" />
    <div class="min-h-screen flex flex-col bg-sky-50">
        <header class="bg-sky-700 text-white p-4 shadow-md">
            <h1 class="text-center font-semibold">Ma Liste de Travail</h1>
        </header>

        <main class="flex-1 p-4 sm:p-8">
            <slot />
        </main>

        <footer class="bg-white border-t p-4 flex justify-around">
            <Link href="/tc/dashboard" class="text-sky-700 flex flex-col items-center">
                <i class="pi pi-home"></i><span class="text-xs">Accueil</span>
            </Link>
            <Link href="/tc/tasks" class="text-gray-500 flex flex-col items-center">
                <i class="pi pi-check-square"></i><span class="text-xs">Tâches</span>
            </Link>
        </footer>
    </div>
</template>