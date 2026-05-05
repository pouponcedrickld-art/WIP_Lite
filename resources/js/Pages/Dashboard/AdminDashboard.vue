<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';

// On définit le layout de manière persistante
defineOptions({ layout: AdminLayout });
</script>

<template>
  <Head title="Dashboard Admin" />
  <div class="card">
    <h2>Statistiques Globales</h2>
    <!-- Contenu spécifique à l'admin -->
  </div>
</template>