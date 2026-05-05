<template>
    <div class="flex min-h-screen bg-slate-50">
        <!-- Sidebar CP -->
        <aside class="w-64 bg-emerald-800 text-white shadow-xl">
            <div class="p-4 font-bold text-xl border-b border-emerald-700">WIP Lite - CP</div>
            <nav class="mt-4 p-2 space-y-2">
                <Link href="/cp/dashboard" class="block p-3 hover:bg-emerald-700 rounded">📊 Vue Globale</Link>
                <Link href="/projects" class="block p-3 hover:bg-emerald-700 rounded">📂 Mes Projets</Link>
                <Link href="/team" class="block p-3 hover:bg-emerald-700 rounded">👥 Équipe</Link>
            </nav>
        </aside>

        <main class="flex-1">
            <header class="bg-white p-4 shadow-sm flex justify-between items-center">
                <span class="font-medium">Espace Chef de Projet</span>
                <div class="flex items-center gap-4">
                    <Avatar icon="pi pi-user" shape="circle" />
                </div>
            </header>
            <div class="p-6">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Avatar from 'primevue/avatar';
</script>