<template>
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
          <Link href="/tc/planning" class="text-gray-500 flex flex-col items-center">
    <i class="pi pi-calendar"></i><span class="text-xs">Mon Planning</span>
</Link>
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>