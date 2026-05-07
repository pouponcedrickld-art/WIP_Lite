<script setup>
import { ref } from "vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link, usePage, router } from "@inertiajs/vue3"; // Ajout de router pour le POST
import OverlayPanel from "primevue/overlaypanel";
import Button from "primevue/button";

const op = ref();
const page = usePage();

const markAsRead = (id) => {
    console.log("Marqué comme lu :", id);
};

// Fonction pour gérer l'activation des comptes (Route POST 'no_users')
const activateUsers = () => {
    router.post(route("no_users"));
};

// Vérifie si la route est active
const isRouteActive = (routeName) => route().current(routeName);
</script>

<template>
    <div
        class="min-h-screen bg-slate-50 flex font-sans antialiased text-slate-900"
    >
        <!-- Sidebar -->
        <aside
            class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 hidden md:flex flex-col border-r border-slate-800"
        >
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <span class="text-white font-black tracking-tighter text-xl">
                    WIP<span class="text-indigo-500">LITE</span>
                </span>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <p
                    class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-4 px-3"
                >
                    Menu Principal
                </p>

                <!-- Dashboard (Route: admin.dashboard) -->
                <Link
                    :href="route('admin.dashboard')"
                    :class="[
                        isRouteActive('admin.dashboard')
                            ? 'bg-slate-800 text-white'
                            : 'hover:bg-slate-800 hover:text-white',
                    ]"
                    class="flex items-center p-3 rounded-xl transition-all duration-200 group"
                >
                    <i
                        class="pi pi-home mr-3 text-lg"
                        :class="
                            isRouteActive('admin.dashboard')
                                ? 'text-indigo-400'
                                : 'text-slate-500 group-hover:text-indigo-400'
                        "
                    ></i>
                    <span class="font-medium">Dashboard</span>
                </Link>

                <!-- Employés (Route: employees.index) -->
                <Link
                    :href="route('employees.index')"
                    :class="[
                        isRouteActive('employees.*')
                            ? 'bg-slate-800 text-white'
                            : 'hover:bg-slate-800 hover:text-white',
                    ]"
                    class="flex items-center p-3 rounded-xl transition-all duration-200 group"
                >
                    <i
                        class="pi pi-users mr-3 text-lg"
                        :class="
                            isRouteActive('employees.*')
                                ? 'text-indigo-400'
                                : 'text-slate-500 group-hover:text-indigo-400'
                        "
                    ></i>
                    <span class="font-medium">Employés</span>
                </Link>

                <!-- Campagnes (Route: campaigns.index) -->
                <Link
                    :href="route('campaigns.index')"
                    :class="[
                        isRouteActive('campaigns.*')
                            ? 'bg-slate-800 text-white'
                            : 'hover:bg-slate-800 hover:text-white',
                    ]"
                    class="flex items-center p-3 rounded-xl transition-all duration-200 group"
                >
                    <i
                        class="pi pi-flag mr-3 text-lg"
                        :class="
                            isRouteActive('campaigns.*')
                                ? 'text-indigo-400'
                                : 'text-slate-500 group-hover:text-indigo-400'
                        "
                    ></i>
                    <span class="font-medium">Campagnes</span>
                </Link>

                <!-- Assignations (Route: assignments.index) -->
                <Link
                    :href="route('assignments.index')"
                    :class="[
                        isRouteActive('assignments.index')
                            ? 'bg-slate-800 text-white'
                            : 'hover:bg-slate-800 hover:text-white',
                    ]"
                    class="flex items-center p-3 rounded-xl transition-all duration-200 group"
                >
                    <i
                        class="pi pi-link mr-3 text-lg"
                        :class="
                            isRouteActive('assignments.index')
                                ? 'text-indigo-400'
                                : 'text-slate-500 group-hover:text-indigo-400'
                        "
                    ></i>
                    <span class="font-medium">Assignations</span>
                </Link>

                <!-- Activation des comptes (Route POST: no_users) -->
                <!-- Note: On utilise un bouton ici car la route est en POST dans web.php -->
                <button
                    @click="activateUsers"
                    class="w-full flex items-center p-3 rounded-xl transition-all duration-200 group hover:bg-slate-800 hover:text-white text-left"
                >
                    <i
                        class="pi pi-user-plus mr-3 text-lg text-slate-500 group-hover:text-indigo-400"
                    ></i>
                    <span class="font-medium">Activation comptes</span>
                </button>
            </nav>

            <!-- Profil Utilisateur -->
            <div class="p-4 border-t border-slate-800">
                <div
                    class="bg-slate-800/50 p-3 rounded-xl flex items-center gap-3"
                >
                    <div
                        class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center text-white font-bold text-xs uppercase"
                    >
                        {{
                            $page.props.auth.user?.name
                                ? $page.props.auth.user.name
                                      .substring(0, 2)
                                      .toUpperCase()
                                : "AD"
                        }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-white truncate">
                            {{ $page.props.auth.user.name }}
                        </p>
                        <p class="text-[10px] text-slate-500 truncate">
                            {{ $page.props.auth.user.email }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->
            <header
                class="h-16 bg-white/80 backdrop-blur-md sticky top-0 z-10 flex items-center justify-between px-8 border-b border-slate-200"
            >
                <h2 class="font-bold text-slate-800 tracking-tight">
                    Administration
                </h2>
                <div class="flex items-center gap-3">
                    <DropdownLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="text-sm font-semibold text-slate-600 hover:text-red-600"
                    >
                        Déconnexion
                    </DropdownLink>
                    <div class="h-8 w-[1px] bg-slate-200 mx-2"></div>
                    <Button
                        type="button"
                        icon="pi pi-bell"
                        @click="(event) => op.toggle(event)"
                        v-badge.danger="
                            $page.props.auth.notifications.length || null
                        "
                        text
                        plain
                        class="!p-2 !w-10 !h-10 !rounded-full hover:!bg-slate-100 transition-colors"
                    />
                </div>
            </header>

            <OverlayPanel
                ref="op"
                style="width: 380px"
                class="shadow-2xl border-slate-200 rounded-2xl overflow-hidden"
            >
                <!-- Contenu des notifications identique -->
                <div
                    class="p-4 border-b border-slate-100 flex justify-between items-center"
                >
                    <span class="font-bold text-slate-800">Notifications</span>
                </div>
                <div class="max-h-[400px] overflow-y-auto">
                    <div v-if="$page.props.auth.notifications.length > 0">
                        <div
                            v-for="notif in $page.props.auth.notifications"
                            :key="notif.id"
                            class="p-4 border-b border-slate-50 hover:bg-slate-50 cursor-pointer flex gap-4"
                        >
                            <div class="flex-1">
                                <p class="text-sm text-slate-700">
                                    {{ notif.data.message }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div v-else class="p-12 text-center text-slate-400">
                        Tout est à jour !
                    </div>
                </div>
            </OverlayPanel>

            <main class="p-8 flex-1">
                <div class="max-w-7xl mx-auto">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
