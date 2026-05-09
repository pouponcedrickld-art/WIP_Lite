<template>
  <CPLayout title="Affectations Planning">
    <ConfirmDialog />

    <div class="p-6">

      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Affectations Planning</h1>
        <!-- Seul l'admin crée des affectations -->
        <!-- Remplacer l'ancienne condition par celle-ci -->
<Button
  v-if="['admin', 'cp'].includes($page.props.auth.user.role.name)"
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
  :value="assignments?.data || []"
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

              <!-- Voir : Tout le monde peut voir -->
              <Button
                icon="pi pi-eye"
                severity="info"
                text
                v-tooltip="'Voir'"
                @click="$inertia.visit(route('planning-assignments.show', data.id))"
              />

              <Button
  v-if="['admin', 'cp'].includes($page.props.auth.user.role.name)"
  icon="pi pi-pencil"
  severity="warning"
  text
  v-tooltip="'Modifier'"
  @click="$inertia.visit(route('planning-assignments.edit', data.id))"
/>


              <!-- Valider : Admin et CP -->
              <Button
                v-if="['admin', 'cp'].includes($page.props.auth.user.role.name) && data.status === 'en attente'"
                icon="pi pi-check"
                severity="success"
                text
                v-tooltip="'Valider'"
                @click="valider(data)"
              />

              <!-- Suspendre : Admin et CP -->
              <Button
                v-if="['admin', 'cp'].includes($page.props.auth.user.role.name) && data.status === 'validé'"
                icon="pi pi-pause"
                severity="warning"
                text
                v-tooltip="'Suspendre'"
                @click="suspendre(data)"
              />

              <!-- Terminer : Admin uniquement -->
              <Button
                v-if="$page.props.auth.user.role.name === 'admin' && data.status !== 'terminé'"
                icon="pi pi-stop"
                severity="danger"
                text
                v-tooltip="'Terminer'"
                @click="terminer(data)"
              />

              <!-- Historique : Admin et CP -->
              <Button
                v-if="['admin', 'cp'].includes($page.props.auth.user.role.name)"
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

  </CPLayout>
</template>


<script setup>
import { useConfirm } from 'primevue/useconfirm'
import { router } from '@inertiajs/vue3'
import CPLayout from '@/Layouts/CPLayout.vue'
// Assure-toi que ces imports correspondent à ta version de PrimeVue
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'
import Tag from 'primevue/tag'
import Message from 'primevue/message'
import ConfirmDialog from 'primevue/confirmdialog'

const props = defineProps({
  assignments: {
    type: Object,
    default: () => ({ data: [] }) // Évite le crash si undefined
  },
})

const confirm = useConfirm()

const statusSeverity = (status) => {
  const map = {
    'en attente': 'warning',
    'validé':     'success',
    'suspendu':   'danger',
    'terminé':    'secondary',
  }
  return map[status] ?? 'info'
}

const valider = (assignment) => {
  confirm.require({
    message: `Valider le planning de "${assignment.employee.name}" ?`,
    header: 'Confirmation',
    accept: () => router.patch(route('planning-assignments.validate', assignment.id))
  })
}

const suspendre = (assignment) => {
  confirm.require({
    message: `Suspendre le planning de "${assignment.employee.name}" ?`,
    header: 'Confirmation',
    accept: () => router.patch(route('planning-assignments.suspend', assignment.id))
  })
}

const terminer = (assignment) => {
  confirm.require({
    message: `Terminer le planning de "${assignment.employee.name}" ?`,
    header: 'Confirmation',
    accept: () => router.patch(route('planning-assignments.terminate', assignment.id))
  })
}
</script>

