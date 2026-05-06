<template>
  <div class="min-h-screen bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm px-6 py-3 flex justify-between items-center">

      <!-- Logo / Titre -->
      <div class="flex items-center gap-3">
        <span class="text-xl font-bold text-blue-700">WIP_lite </span>
      </div>

      <!-- Menu navigation -->
      <div class="flex items-center gap-2">

        <Button
          label="Modèles Planning"
          icon="pi pi-table"
          text
          @click="$inertia.visit(route('planning-models.index'))"
        />

        <Button
          label="Affectations"
          icon="pi pi-users"
          text
          @click="$inertia.visit(route('planning-assignments.index'))"
        />

      </div>

      <!-- Utilisateur connecté + Déconnexion -->
      <div class="flex items-center gap-3">
        <span class="text-gray-600 text-sm font-medium">
          {{ $page.props.auth.user.name }}
        </span>
        <Button
          label="Déconnexion"
          icon="pi pi-sign-out"
          severity="danger"
          text
          @click="logout"
        />
      </div>

    </nav>

    <!-- Titre de la page -->
    <header class="bg-white border-b px-6 py-4" v-if="title">
      <h2 class="text-lg font-semibold text-gray-700">{{ title }}</h2>
    </header>

    <!-- Contenu principal -->
    <main>
      <slot />
    </main>

    
    <!-- Toast global pour les notifications -->
    <Toast />

  <!-- ConfirmDialog global -->
  <ConfirmDialog />
  
</div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { Button, Toast, ConfirmDialog } from 'primevue'

defineProps({
  title: {
    type: String,
    default: null,
  },
})

function logout() {
  useForm({}).post(route('logout'))
}
</script>