<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Sidebar / Nav spécifique Admin -->
    <nav class="bg-indigo-900 text-white p-4">
      <h1>Panel Administrateur</h1>
      <!-- Liens : Gestion users, logs, etc. -->
    </nav>

    <main class="p-6">
      <slot /> <!-- C'est ici que s'affichera le Dashboard -->
    </main>
  </div>
</template>