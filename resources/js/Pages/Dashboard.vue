<script setup>
import { onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3'; // Import de Link pour la navigation Inertia
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';
import Card from 'primevue/card'; // Import des cartes

const toast = useToast();

const navItems = [
    {
        title: 'Campagnes',
        description: 'Gérer les cycles de production et campagnes.',
        icon: 'pi pi-megaphone',
        route: 'campaigns.index',
        color: 'text-emerald-600',
        bgColor: 'bg-emerald-50'
    },
    {
        title: 'Assignations',
        description: 'Gérer les affectations des employés et managers.',
        icon: 'pi pi-users',
        route: 'assignments.index', // À créer prochainement
        color: 'text-amber-600',
        bgColor: 'bg-amber-50'
    },
    {
        title: 'Planning',
        description: 'Organisation des horaires et des ressources.',
        icon: 'pi pi-calendar',
        route: 'plannings.index', // À créer prochainement
        color: 'text-blue-600',
        bgColor: 'bg-blue-50'
    },
];

onMounted(() => {
    toast.add({ severity: 'success', summary: 'Bienvenue', detail: 'Heureux de vous revoir !', life: 3000 })
});
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <Toast />
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tableau de bord
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Grille de navigation -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div v-for="item in navItems" :key="item.title">
                        <Link :href="route().has(item.route) ? route(item.route) : '#'" class="no-underline">
                            <Card class="hover:shadow-lg transition-shadow duration-300 border-none h-full cursor-pointer">
                                <template #content>
                                    <div class="flex items-center gap-4">
                                        <div :class="['p-4 rounded-xl', item.bgColor]">
                                            <i :class="[item.icon, item.color, 'text-2xl']"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-800">{{ item.title }}</h3>
                                            <p class="text-sm text-gray-500">{{ item.description }}</p>
                                        </div>
                                    </div>
                                </template>
                            </Card>
                        </Link>
                    </div>
                </div>

                <!-- Section Statistiques Rapides (Optionnel) -->
                <div class="mt-8 overflow-hidden bg-white shadow-sm sm:rounded-lg border border-gray-100">
                    <div class="p-6 text-gray-900 font-medium">
                        Dernières activités du système
                        <p class="text-sm text-gray-400 mt-1">Consultez les mises à jour récentes de vos projets.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Petit effet de zoom au survol pour le côté "Wow" */
.p-card:hover {
    transform: translateY(-4px);
}
.p-card {
    transition: transform 0.2s ease-in-out;
}
</style>
