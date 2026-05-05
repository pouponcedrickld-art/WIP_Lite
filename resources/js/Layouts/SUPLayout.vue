<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Top Navigation SUP -->
        <nav class="bg-amber-600 text-white p-4 flex justify-between">
            <div class="flex gap-8 items-center">
                <span class="font-bold">WIP Lite SUP</span>
                <Link href="/sup/dashboard" class="hover:underline">Contrôle</Link>
                <Link href="/approvals" class="hover:underline">Validations</Link>
            </div>
            <Button icon="pi pi-sign-out" class="p-button-text text-white" />
        </nav>

        <div class="max-w-7xl mx-auto py-8 px-4">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Button from 'primevue/button';
</script>