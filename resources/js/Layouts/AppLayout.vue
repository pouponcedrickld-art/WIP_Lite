<template>
    <!-- TOAST GLOBAL -->
    <Toast appendTo="body" position="top-right" />

    <!-- layout selon rôle -->
    <component :is="layout">
        <slot />
    </component>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import CPLayout from '@/Layouts/CPLayout.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const page = usePage();

const layout = computed(() => {
    const role = page.props.auth?.user?.role?.name;
    return role === 'cp' ? CPLayout : AdminLayout;
});
</script>

