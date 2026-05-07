<script setup>
import { ref, computed } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import Dialog from "primevue/dialog";
import Select from "primevue/select";
import ConfirmDialog from "primevue/confirmdialog";
import { useConfirm } from "primevue/useconfirm";
import Tag from 'primevue/tag';

const props = defineProps({
    campaignsTree: Array,
    availableEmployees: Array,
    campaigns: Array,
});

const confirm = useConfirm();
const displayModal = ref(false);
const selectedEmployee = ref(null);

const form = useForm({
    employee_id: "",
    campaign_id: "",
    manager_id: null,
    position_id: null,
});

// --- HELPERS DE FILTRAGE ---
const getCPs = (campaign) => campaign.assignments?.filter(a => a.position_id === 1) || [];
const getSUPs = (campaign, cpId) => campaign.assignments?.filter(a => a.position_id === 2 && a.manager_id === cpId) || [];
const getTCs = (campaign, supId) => campaign.assignments?.filter(a => a.position_id === 3 && a.manager_id === supId) || [];

const activeCampaigns = computed(() => props.campaignsTree?.filter(c => c.assignments?.length > 0) || []);

const getCampaignStats = (campaign) => {
    const total = campaign.assignments?.length || 0;
    const tcs = campaign.assignments?.filter(a => a.position_id === 3).length || 0;
    return { total, tcs };
};

const formatDate = (dateString) => {
    if (!dateString) return 'Récents';
    return new Date(dateString).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' });
};

// --- LOGIQUE VIVIER REGROUPÉ (CORRIGÉE) ---
const vivierByPosition = computed(() => {
    const assignedIds = props.campaignsTree?.flatMap(c => c.assignments?.map(a => a.employee_id) || []) || [];
    const available = props.availableEmployees?.filter(emp => !assignedIds.includes(emp.id)) || [];
    
    return {
        CP: available.filter(e => e.position_id === 1),
        SUP: available.filter(e => e.position_id === 2),
        TC: available.filter(e => e.position_id === 3),
    };
});

const openAssignModal = (emp) => {
    form.reset();
    selectedEmployee.value = emp;
    form.employee_id = emp.id;
    displayModal.value = true;
};

const confirmRelease = (id) => {
    confirm.require({
        header: 'Libération d\'agent',
        message: 'L\'agent sera remis dans le vivier immédiatement.',
        icon: 'pi pi-info-circle',
        acceptLabel: 'Confirmer',
        acceptClass: 'p-button-danger p-button-sm',
        accept: () => router.delete(route("assignments.release", id))
    });
};
</script>

<template>
    <ConfirmDialog />

    <div class="p-8 bg-slate-50 min-h-screen font-sans">
        <div class="flex flex-col lg:flex-row gap-8 max-w-[1650px] mx-auto">
            
            <div class="flex-1 space-y-8">
                <header class="flex justify-between items-end mb-4">
                    <div>
                        <h1 class="text-2xl font-black text-slate-800 tracking-tight">PLATEAU ACTIF</h1>
                        <p class="text-slate-500 text-sm italic">{{ activeCampaigns.length }} campagnes en cours</p>
                    </div>
                </header>

                <div v-for="campaign in activeCampaigns" :key="campaign.id" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 bg-slate-900 text-white flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <i class="pi pi-bolt text-yellow-400"></i>
                            <span class="font-black uppercase tracking-tighter">{{ campaign.name }}</span>
                        </div>
                        <div class="flex gap-2">
                            <Tag :value="`${getCampaignStats(campaign).total} Agents`" severity="secondary" class="!bg-slate-700 !text-white" />
                            <Tag :value="`${getCampaignStats(campaign).tcs} TC`" severity="info" />
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-8">
                        <div v-for="cp in getCPs(campaign)" :key="cp.id" class="space-y-6">
                            <div class="flex items-center justify-between p-4 bg-orange-50 border-l-4 border-orange-500 rounded-r-xl shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center text-white">
                                        <i class="pi pi-star-fill text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 leading-none">{{ cp.employee.first_name }} {{ cp.employee.last_name }}</p>
                                        <span class="text-[10px] text-orange-600 font-bold uppercase tracking-widest">Chef de Projet • {{ formatDate(cp.created_at) }}</span>
                                    </div>
                                </div>
                                <button @click="confirmRelease(cp.id)" class="p-button-text p-button-danger"><i class="pi pi-sign-out"></i></button>
                            </div>

                            <div v-for="sup in getSUPs(campaign, cp.employee_id)" :key="sup.id" class="ml-12 border-l-2 border-slate-100 pl-8 space-y-4">
                                <div class="flex items-center justify-between p-3 bg-emerald-900 text-white rounded-xl shadow-md">
                                    <div class="flex items-center gap-3">
                                        <i class="pi pi-shield text-xs"></i>
                                        <span class="text-sm font-bold tracking-tight">{{ sup.employee.first_name }} {{ sup.employee.last_name }}</span>
                                    </div>
                                    <button @click="confirmRelease(sup.id)" class="text-emerald-300 hover:text-white"><i class="pi pi-times text-xs"></i></button>
                                </div>

                                <div class="ml-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                                    <div v-for="tc in getTCs(campaign, sup.employee_id)" :key="tc.id" 
                                         class="flex flex-col p-3 bg-white border border-slate-200 rounded-xl hover:shadow-md transition-all group">
                                        <div class="flex justify-between items-start mb-1">
                                            <span class="text-xs font-black text-slate-700 uppercase tracking-tighter">{{ tc.employee.first_name }}</span>
                                            <button @click="confirmRelease(tc.id)" class="opacity-0 group-hover:opacity-100 text-red-400 transition-opacity">
                                                <i class="pi pi-trash text-[10px]"></i>
                                            </button>
                                        </div>
                                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest italic">Affecté le {{ formatDate(tc.created_at) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="w-full lg:w-80">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm sticky top-6">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest">Vivier Disponible</h3>
                        <i class="pi pi-info-circle text-slate-300"></i>
                    </div>
                    
                    <div class="p-4 space-y-6 overflow-y-auto max-h-[80vh]">
                        <div v-if="vivierByPosition.CP?.length" class="space-y-2">
                            <p class="text-[10px] font-black text-orange-500 uppercase ml-1 tracking-widest">Chefs de Projet</p>
                            <div v-for="emp in vivierByPosition.CP" :key="emp.id" class="p-3 bg-orange-50 rounded-lg flex justify-between items-center border border-orange-100">
                                <span class="text-xs font-bold text-orange-900">{{ emp.first_name }}</span>
                                <button @click="openAssignModal(emp)" class="text-orange-600"><i class="pi pi-plus-circle"></i></button>
                            </div>
                        </div>

                        <div v-if="vivierByPosition.SUP?.length" class="space-y-2">
                            <p class="text-[10px] font-black text-emerald-600 uppercase ml-1 tracking-widest">Superviseurs</p>
                            <div v-for="emp in vivierByPosition.SUP" :key="emp.id" class="p-3 bg-emerald-50 rounded-lg flex justify-between items-center border border-emerald-100">
                                <span class="text-xs font-bold text-emerald-900">{{ emp.first_name }}</span>
                                <button @click="openAssignModal(emp)" class="text-emerald-600"><i class="pi pi-plus-circle"></i></button>
                            </div>
                        </div>

                        <div v-if="vivierByPosition.TC?.length" class="space-y-2">
                            <p class="text-[10px] font-black text-slate-400 uppercase ml-1 tracking-widest">Téléconseillers</p>
                            <div v-for="emp in vivierByPosition.TC" :key="emp.id" class="p-3 bg-slate-50 rounded-lg flex justify-between items-center border border-slate-100 hover:bg-white transition-colors">
                                <span class="text-xs font-bold text-slate-700">{{ emp.first_name }} {{ emp.last_name }}</span>
                                <button @click="openAssignModal(emp)" class="text-slate-400 hover:text-slate-900"><i class="pi pi-plus-circle"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <Dialog v-model:visible="displayModal" modal header="Affectation Plateau" :style="{ width: '32rem' }" class="rounded-2xl">
        <div class="p-2 space-y-6">
            <div class="text-center pb-4">
                <i class="pi pi-user-plus text-4xl text-slate-200 mb-2"></i>
                <h2 class="text-xl font-black text-slate-800">{{ selectedEmployee?.first_name }} {{ selectedEmployee?.last_name }}</h2>
            </div>
            
            <div class="grid gap-4">
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Campagne de destination</label>
                    <Select v-model="form.campaign_id" :options="campaigns" optionLabel="name" optionValue="id" placeholder="Choisir une campagne" class="w-full" />
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Rôle</label>
                    <Select v-model="form.position_id" :options="[{l:'CP',v:1},{l:'SUP',v:2},{l:'TC',v:3}]" optionLabel="l" optionValue="v" class="w-full" />
                </div>
            </div>

            <button @click="form.post(route('assignments.store'), { onSuccess: () => displayModal = false })"
                    class="w-full bg-slate-900 text-white font-black py-4 rounded-xl hover:bg-orange-600 transition-all shadow-lg mt-4">
                VALIDER L'AFFECTATION
            </button>
        </div>
    </Dialog>
</template>