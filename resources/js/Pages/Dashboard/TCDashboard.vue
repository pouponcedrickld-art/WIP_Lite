<script setup>
import { Head, Link } from '@inertiajs/vue3';
import StatCard from '@/Components/StatCard.vue';
import TCLayout from '../../Layouts/TCLayout.vue';

defineOptions({ layout: TCLayout });

// On récupère les props envoyées par le TcController
defineProps({
    auth_employee: Object,
    assignment: Object,
    today_schedule: Object,
    my_stats: Object
});
</script>

<template>
  <Head title="Mon Tableau de Bord" />

  <div class="space-y-8">
    <!-- Header Dynamique -->
    <div class="flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-black text-slate-800 tracking-tight uppercase tracking-tighter">
            Bonjour, {{ auth_employee.full_name }}
        </h1>
        <p class="text-slate-500">Heureux de vous revoir. Voici votre situation aujourd'hui.</p>
      </div>
      
      <!-- Lien dynamique vers la campagne actuelle -->
      <div v-if="assignment">
          <Link :href="route('reporting.index')" class="px-6 py-3 bg-[#FF7A1A] text-white rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-orange-100 hover:bg-slate-900 transition-all">
            Saisir ma production
          </Link>
      </div>
    </div>

    <!-- Stats TC Dynamiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <StatCard title="Score Qualité" :value="my_stats.quality_score + '%'" icon="pi-star-fill" iconBg="bg-orange-50" iconColor="text-orange-600" />
      <StatCard title="Jours de Congés" :value="my_stats.off_days" icon="pi-calendar" iconBg="bg-slate-100" iconColor="text-slate-600" />
      <StatCard title="Objectif Journalier" value="100%" icon="pi-target" iconBg="bg-orange-100" iconColor="text-orange-600" />
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Infos Affectation & Superviseur -->
        <div class="xl:col-span-2 bg-white rounded-3xl border border-orange-100 shadow-xl shadow-orange-200/10 overflow-hidden">
            <div class="p-6 border-b border-orange-50 flex justify-between items-center bg-orange-50/20">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-[#FF7A1A] rounded-full"></div>
                    <h3 class="font-black text-slate-800 uppercase tracking-tighter">Mon Affectation Actuelle</h3>
                </div>
                <span class="text-[9px] font-black text-orange-400 italic uppercase tracking-[0.2em]">Info Poste</span>
            </div>
            
            <div class="p-8">
                <div v-if="assignment" class="flex flex-col md:flex-row gap-8 items-center justify-around">
                    <!-- Campagne -->
                    <div class="text-center">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Campagne</p>
                        <div class="px-4 py-2 bg-orange-100 rounded-lg text-orange-700 font-black uppercase text-sm">
                            {{ assignment.campaign_name }}
                        </div>
                    </div>

                    <!-- Séparateur -->
                    <div class="hidden md:block w-px h-12 bg-slate-100"></div>

                    <!-- Superviseur -->
                    <div class="text-center">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Mon Superviseur</p>
                        <div class="flex items-center gap-3 justify-center">
                            <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-white font-black text-xs">
                                {{ assignment.manager_name.charAt(0) }}
                            </div>
                            <p class="font-bold text-slate-800">{{ assignment.manager_name }}</p>
                        </div>
                    </div>
                </div>

                <div v-else class="text-center py-10">
                    <i class="pi pi-exclamation-circle text-orange-200 text-4xl mb-4"></i>
                    <p class="text-slate-400 font-black uppercase tracking-widest text-xs">Aucune affectation active</p>
                </div>
            </div>
        </div>

        <!-- Widget Planning Dynamique -->
        <div class="bg-orange-950 rounded-3xl p-8 text-white shadow-2xl shadow-orange-900/40 flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-orange-500/10 rounded-full blur-3xl group-hover:bg-orange-500/20 transition-all"></div>
            <div>
                <div class="w-12 h-12 bg-orange-500/20 rounded-xl flex items-center justify-center mb-8 border border-orange-500/30">
                    <i class="pi pi-clock text-orange-400 text-xl"></i>
                </div>
                <h4 class="text-xl font-black mb-3 tracking-tighter uppercase">Mon Planning</h4>
                
                <div class="space-y-4 mb-10">
                    <div class="flex justify-between items-center border-b border-white/10 pb-2">
                        <span class="text-xs text-orange-200/60 uppercase font-black">Matin</span>
                        <span class="font-mono font-bold">{{ today_schedule.morning_start }} - {{ today_schedule.morning_end }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-white/10 pb-2">
                        <span class="text-xs text-orange-200/60 uppercase font-black">Pause Déj.</span>
                        <span class="font-mono font-bold text-orange-400">{{ today_schedule.lunch_break }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-white/10 pb-2">
                        <span class="text-xs text-orange-200/60 uppercase font-black">Après-midi</span>
                        <span class="font-mono font-bold">{{ today_schedule.afternoon_start }} - {{ today_schedule.afternoon_end }}</span>
                    </div>
                </div>
            </div>
            
            <button class="w-full py-4 bg-orange-600 hover:bg-white hover:text-orange-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-orange-900/20">
                Déclarer une absence
            </button>
        </div>
    </div>
  </div>
</template>