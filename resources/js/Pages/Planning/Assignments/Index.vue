<script setup>

import { useConfirm } from 'primevue/useconfirm'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AdminLayout.vue'
import { Button, DataTable, Column, Tag, Message, ConfirmDialog } from 'primevue'

const props = defineProps({
  assignments: Object,
})

const confirm = useConfirm()

function statusSeverity(status) {
  const map = {
    'en attente': 'warning',
    'validé':     'success',
    'suspendu':   'danger',
    'terminé':    'secondary',
  }
  return map[status] ?? 'info'
}

function valider(assignment) {
  confirm.require({
    message: `Valider le planning de "${assignment.employee.name}" ?`,
    header: 'Confirmation',
    icon: 'pi pi-check-circle',
    acceptLabel: 'Valider',
    rejectLabel: 'Annuler',
    accept: () => {
      useForm({}).patch(route('planning-assignments.validate', assignment.id))
    },
  })
}

function suspendre(assignment) {
  confirm.require({
    message: `Suspendre le planning de "${assignment.employee.name}" ?`,
    header: 'Confirmation',
    icon: 'pi pi-pause',
    acceptLabel: 'Suspendre',
    rejectLabel: 'Annuler',
    acceptClass: 'p-button-warning',
    accept: () => {
      useForm({}).patch(route('planning-assignments.suspend', assignment.id))
    },
  })
}

function terminer(assignment) {
  confirm.require({
    message: `Terminer le planning de "${assignment.employee.name}" ? Cette action est irréversible.`,
    header: 'Confirmation',
    icon: 'pi pi-exclamation-triangle',
    acceptLabel: 'Terminer',
    rejectLabel: 'Annuler',
    acceptClass: 'p-button-danger',
    accept: () => {
      useForm({}).patch(route('planning-assignments.terminate', assignment.id))
    },
  })
}
</script>

<template>
  <AppLayout title="Affectations Planning">
    <div class="p-6">

      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Affectations Planning</h1>
        <Button
          label="Nouvelle affectation"
          icon="pi pi-plus"
          @click="$inertia.visit(route('planning-assignments.create'))"
        />
      </div>

      <!-- Flash messages -->
      <Message v-if="$page.props.flash?.success" severity="success" class="mb-4">
        {{ $page.props.flash.success }}
      </Message>
      <Message v-if="$page.props.flash?.error" severity="error" class="mb-4">
        {{ $page.props.flash.error }}
      </Message>

      <!-- Table -->
      <DataTable
        :value="assignments.data"
        paginator
        :rows="10"
        stripedRows
        class="shadow rounded-xl"
      >
        <Column header="Employé">
          <template #body="{ data }">
            <div>
              <p class="font-semibold">{{ data.employee.name }}</p>
              <p class="text-sm text-gray-400">{{ data.employee.matricule }}</p>
            </div>
          </template>
        </Column>

        <Column header="Modèle Planning">
          <template #body="{ data }">
            <div>
              <p class="font-semibold">{{ data.planning_model.name }}</p>
              <Tag :value="data.planning_model.total_hours + 'h/sem'" severity="info" />
            </div>
          </template>
        </Column>

        <Column field="start_date" header="Début" sortable />
        <Column header="Fin">
          <template #body="{ data }">
            {{ data.end_date ?? 'En cours' }}
          </template>
        </Column>

        <Column header="Statut">
          <template #body="{ data }">
            <Tag :value="data.status" :severity="statusSeverity(data.status)" />
          </template>
        </Column>

        <Column header="Actions">
          <template #body="{ data }">
            <div class="flex gap-2 flex-wrap">

              <!-- Voir -->
              <Button
                icon="pi pi-eye"
                severity="info"
                text
                v-tooltip="'Voir'"
                @click="$inertia.visit(route('planning-assignments.show', data.id))"
              />

              <!-- Modifier -->
              <Button
                icon="pi pi-pencil"
                severity="warning"
                text
                v-tooltip="'Modifier'"
                :disabled="data.status === 'validé'"
                @click="$inertia.visit(route('planning-assignments.edit', data.id))"
              />

              <!-- Valider -->
              <Button
                v-if="data.status === 'en attente'"
                icon="pi pi-check"
                severity="success"
                text
                v-tooltip="'Valider'"
                @click="valider(data)"
              />

              <!-- Suspendre -->
              <Button
                v-if="data.status === 'validé'"
                icon="pi pi-pause"
                severity="warning"
                text
                v-tooltip="'Suspendre'"
                @click="suspendre(data)"
              />

              <!-- Terminer -->
              <Button
                v-if="data.status !== 'terminé'"
                icon="pi pi-stop"
                severity="danger"
                text
                v-tooltip="'Terminer'"
                @click="terminer(data)"
              />

              <!-- Historique -->
              <Button
                icon="pi pi-history"
                severity="secondary"
                text
                v-tooltip="'Historique'"
                @click="$inertia.visit(route('planning-assignments.history', data.id))"
              />

            </div>
          </template>
        </Column>
      </DataTable>

    </div>

  </AppLayout>
</template>

