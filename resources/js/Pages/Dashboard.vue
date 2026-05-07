<script setup>
import { onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';
import { Link } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Card from 'primevue/card';
const toast = useToast();

onMounted(() => {
    toast.add({
        severity: 'success',
        summary: 'Bienvenue 👋',
        detail: 'Heureux de vous revoir sur votre tableau de bord !',
        life: 4000
    });
});



</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <Toast />
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Tableau de Bord
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Carte de bienvenue -->
                <Card class="mb-8">
                    <template #title>
                        <div class="flex items-center">
                            <i class="pi pi-home mr-2 text-blue-500"></i>
                            Bienvenue sur votre tableau de bord
                        </div>
                    </template>
                    <template #content>
                        <p class="text-gray-600 mb-6">
                            Gérez facilement vos employés, campagnes et affectations depuis cette interface centralisée.
                        </p>
                        
                        <!-- Actions rapides -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Carte Employés -->
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Gestion des Employés</h3>
                                        <p class="text-blue-100 text-sm">Créer, modifier et gérer les employés</p>
                                    </div>
                                    <i class="pi pi-users text-3xl text-blue-200"></i>
                                </div>
                                <div class="mt-4">
                                    <Link :href="route('employees.index')">
                                        <Button 
                                            label="Accéder aux Employés" 
                                            icon="pi pi-arrow-right" 
                                            class="p-button-outlined bg-white text-blue-600 hover:bg-blue-50"
                                        />
                                    </Link>
                                </div>
                            </div>

                            <!-- Carte Statistiques -->
                            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Statistiques</h3>
                                        <p class="text-green-100 text-sm">Vue d'ensemble des effectifs</p>
                                    </div>
                                    <i class="pi pi-chart-bar text-3xl text-green-200"></i>
                                </div>
                                <div class="mt-4">
                                    <Button 
                                        label="Voir les Stats" 
                                        icon="pi pi-chart-line" 
                                        class="p-button-outlined bg-white text-green-600 hover:bg-green-50"
                                        disabled
                                    />
                                </div>
                            </div>

                            <!-- Carte Campagnes -->
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Campagnes</h3>
                                        <p class="text-purple-100 text-sm">Gestion des campagnes actives</p>
                                    </div>
                                    <i class="pi pi-briefcase text-3xl text-purple-200"></i>
                                </div>
                                <div class="mt-4">
                                    <Button 
                                        label="Voir les Campagnes" 
                                        icon="pi pi-briefcase" 
                                        class="p-button-outlined bg-white text-purple-600 hover:bg-purple-50"
                                        disabled
                                    />
                                </div>
                            </div>
                        </div>
                    </template>
                </Card>

                <!-- Informations récentes -->
                <Card>
                    <template #title>
                        <div class="flex items-center">
                            <i class="pi pi-info-circle mr-2 text-blue-500"></i>
                            Informations
                        </div>
                    </template>
                    <template #content>
                        <div class="space-y-4">
                            <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                                <i class="pi pi-users mr-3 text-blue-500 text-xl"></i>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Module Employés Actif</h4>
                                    <p class="text-gray-600 text-sm">Le module de gestion des employés est entièrement fonctionnel</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-4 bg-green-50 rounded-lg">
                                <i class="pi pi-check-circle mr-3 text-green-500 text-xl"></i>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Données de Test Disponibles</h4>
                                    <p class="text-gray-600 text-sm">40+ employés générés pour les tests</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                                <i class="pi pi-shield mr-3 text-purple-500 text-xl"></i>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Sécurité Activée</h4>
                                    <p class="text-gray-600 text-sm">Toutes les routes sont protégées par authentification</p>
                                </div>
                            </div>
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
