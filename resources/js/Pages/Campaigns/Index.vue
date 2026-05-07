<script setup>
import { ref } from "vue";
import { useForm, Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Textarea from "primevue/textarea";
import Select from "primevue/select";

const props = defineProps({ campaigns: Array });
const displayDialog = ref(false);
const isEditing = ref(false);

const statuses = [
    { label: "Active", value: "active" },
    { label: "Inactive", value: "inactive" },
    { label: "Terminée", value: "completed" },
];

const form = useForm({
    id: null,
    name: "",
    description: "",
    start_date: "",
    end_date: "",
    status: "active",
});

const openNew = () => {
    isEditing.value = false;
    form.reset();
    form.clearErrors();
    displayDialog.value = true;
};

const editCampaign = (campaign) => {
    isEditing.value = true;
    form.clearErrors();
    form.id = campaign.id;
    form.name = campaign.name;
    form.description = campaign.description;
    form.start_date = campaign.start_date;
    form.end_date = campaign.end_date;
    form.status = campaign.status;
    displayDialog.value = true;
};

const saveCampaign = () => {
    if (isEditing.value) {
        form.put(route("campaigns.update", { campaign: form.id }), {
            onSuccess: () => {
                displayDialog.value = false;
                form.reset();
            },
        });
    } else {
        form.post(route("campaigns.store"), {
            onSuccess: () => {
                displayDialog.value = false;
                form.reset();
            },
        });
    }
};

const deleteCampaign = (id) => {
    if (confirm("Supprimer cette campagne ?")) {
        form.delete(route("campaigns.destroy", id));
    }
};
</script>

<template>
    <Head title="Campagnes | WIP_Lite" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center py-2">
                <h2
                    class="text-xl font-bold text-slate-800 tracking-tight uppercase"
                >
                    Vos Campagnes
                </h2>
                <button @click="openNew" class="btn-primary">
                    <i class="pi pi-plus mr-2 text-[10px]"></i> NOUVELLE
                    CAMPAGNE
                </button>
            </div>
        </template>

        <div class="py-10 bg-slate-50 min-h-screen">
            <div class="max-w-6xl mx-auto px-4">
                <div class="grid gap-3">
                    <div
                        v-for="campaign in campaigns"
                        :key="campaign.id"
                        class="bg-white p-5 rounded-xl border border-slate-200 flex items-center justify-between shadow-sm hover:shadow-md transition-all"
                    >
                        <div class="flex items-center gap-5">
                            <!-- Retour du contraste Orange (#FF7A1A) -->
                            <div
                                :class="[
                                    'w-1.5 h-12 rounded-full',
                                    campaign.status === 'active'
                                        ? 'bg-[#FF7A1A]'
                                        : 'bg-slate-300',
                                ]"
                            ></div>
                            <div>
                                <h3
                                    class="font-bold text-slate-800 uppercase text-sm"
                                >
                                    {{ campaign.name }}
                                </h3>
                                <p
                                    class="text-slate-500 text-xs mt-1 leading-relaxed"
                                >
                                    {{
                                        campaign.description ||
                                        "Pas de description."
                                    }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-8">
                            <div
                                class="text-[11px] font-bold text-slate-400 text-right"
                            >
                                <span
                                    class="block opacity-50 uppercase text-[9px]"
                                    >Période</span
                                >
                                {{ campaign.start_date }} —
                                {{ campaign.end_date }}
                            </div>
                            <div class="flex gap-1">
                                <Link
                                    :href="route('campaigns.show', campaign.id)"
                                    class="btn-icon text-slate-400 hover:text-slate-800"
                                >
                                    <i class="pi pi-eye text-sm"></i>
                                </Link>
                                <button
                                    @click="editCampaign(campaign)"
                                    class="btn-icon text-slate-400 hover:bg-slate-100 hover:text-slate-600"
                                >
                                    <i class="pi pi-pencil text-sm"></i>
                                </button>
                                <button
                                    @click="deleteCampaign(campaign.id)"
                                    class="btn-icon text-slate-300 hover:bg-red-50 hover:text-red-500"
                                >
                                    <i class="pi pi-trash text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Dialog
            v-model:visible="displayDialog"
            modal
            :header="isEditing ? 'MODIFIER LA CAMPAGNE' : 'NOUVELLE CAMPAGNE'"
            :style="{ width: '420px' }"
            class="white-dialog-fixed"
        >
            <div class="flex flex-col gap-5 pt-4 bg-white">
                <div class="flex flex-col gap-1.5">
                    <label class="label-style">Nom du projet</label>
                    <InputText
                        v-model="form.name"
                        class="p-input-custom"
                        placeholder="Nom..."
                    />
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="label-style">Description</label>
                    <Textarea
                        v-model="form.description"
                        rows="3"
                        class="p-input-custom"
                        placeholder="Détails..."
                    />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="label-style">Début</label>
                        <InputText
                            type="date"
                            v-model="form.start_date"
                            class="p-input-custom"
                        />
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="label-style">Fin</label>
                        <InputText
                            type="date"
                            v-model="form.end_date"
                            class="p-input-custom"
                        />
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="label-style">Statut</label>
                    <Select
                        v-model="form.status"
                        :options="statuses"
                        optionLabel="label"
                        optionValue="value"
                        class="p-input-custom"
                    />
                </div>
            </div>

            <template #footer>
                <div
                    class="flex items-center justify-end gap-3 pt-6 bg-white border-t border-slate-50"
                >
                    <button
                        @click="displayDialog = false"
                        class="text-[10px] font-bold text-slate-400 hover:text-slate-600 uppercase tracking-widest px-4"
                    >
                        Annuler
                    </button>
                    <button
                        @click="saveCampaign"
                        class="btn-save"
                        :disabled="form.processing"
                    >
                        {{ isEditing ? "METTRE À JOUR" : "CRÉER" }}
                    </button>
                </div>
            </template>
        </Dialog>
    </AuthenticatedLayout>
</template>

<style>
/* STYLE GLOBAL : Écrase le mode sombre et restaure le thème orange */

.white-dialog-fixed.p-dialog {
    background: #ffffff !important;
    border: 1px solid #f1f5f9 !important;
    border-radius: 12px !important;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1) !important;
}

.white-dialog-fixed .p-dialog-header,
.white-dialog-fixed .p-dialog-content,
.white-dialog-fixed .p-dialog-footer {
    background: #ffffff !important;
    border: none !important;
    color: #334155 !important;
}

/* Forçage des éléments de formulaire en blanc pur */
.p-input-custom.p-inputtext,
.p-input-custom.p-textarea,
.p-input-custom.p-select {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    color: #334155 !important;
    box-shadow: none !important;
    border-radius: 8px !important;
}

.p-input-custom.p-select .p-select-label {
    color: #334155 !important;
}

/* Accentuation Orange lors du focus */
.p-input-custom.p-inputtext:focus,
.p-input-custom.p-select.p-focus {
    border-color: #ff7a1a !important;
}

/* Boutons WIP_Lite avec accentuation orange au survol */
.btn-primary {
    @apply bg-slate-900 text-white text-[10px] font-black px-6 py-2.5 rounded hover:bg-[#FF7A1A] transition-all tracking-widest;
}
.btn-save {
    @apply bg-slate-800 text-white text-[10px] font-bold px-8 py-3 rounded hover:bg-[#FF7A1A] transition-all tracking-widest shadow-lg;
}
.btn-icon {
    @apply w-9 h-9 flex items-center justify-center rounded-lg transition-all;
}
.label-style {
    @apply text-[10px] font-black text-slate-400 uppercase tracking-widest;
}

/* Masque de fond léger */
.p-component-overlay {
    background-color: rgba(15, 23, 42, 0.1) !important;
    backdrop-filter: blur(4px) !important;
}
</style>
