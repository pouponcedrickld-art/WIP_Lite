<script setup>
import { ref } from "vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link, usePage } from "@inertiajs/vue3";
import OverlayPanel from "primevue/overlaypanel";
import Button from "primevue/button";

const op = ref();
const page = usePage();

const markAsRead = (id) => {
    // Logique router.post ici plus tard
    console.log("Marqué comme lu :", id);
};

// Fonction pour gérer la classe active des liens
const isActive = (route) => page.url.startsWith(route);
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
                <span class="text-white font-black tracking-tighter text-xl"
                    >WIP<span class="text-indigo-500">LITE</span></span
                >
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <p
                    class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-4 px-3"
                >
                    Menu Principal
                </p>

                <Link
                    href="/admin/dashboard"
                    :class="[
                        isActive('/admin/dashboard')
                            ? 'bg-slate-800 text-white'
                            : 'hover:bg-slate-800 hover:text-white',
                    ]"
                    class="flex items-center p-3 rounded-xl transition-all duration-200 group"
                >
                    <i
                        class="pi pi-home mr-3 text-lg"
                        :class="
                            isActive('/admin/dashboard')
                                ? 'text-indigo-400'
                                : 'text-slate-500 group-hover:text-indigo-400'
                        "
                    ></i>
                    <span class="font-medium">Dashboard</span>
                </Link>

                <Link
                    href="/admin/employees"
                    :class="[
                        isActive('/admin/employees')
                            ? 'bg-slate-800 text-white'
                            : 'hover:bg-slate-800 hover:text-white',
                    ]"
                    class="flex items-center p-3 rounded-xl transition-all duration-200 group"
                >
                    <i
                        class="pi pi-users mr-3 text-lg"
                        :class="
                            isActive('/admin/employees')
                                ? 'text-indigo-400'
                                : 'text-slate-500 group-hover:text-indigo-400'
                        "
                    ></i>
                    <span class="font-medium">Employés</span>
                </Link>

                <Link
                    href="/admin/campaigns"
                    :class="[
                        isActive('/admin/campaigns')
                            ? 'bg-slate-800 text-white'
                            : 'hover:bg-slate-800 hover:text-white',
                    ]"
                    class="flex items-center p-3 rounded-xl transition-all duration-200 group"
                >
                    <i
                        class="pi pi-flag mr-3 text-lg"
                        :class="
                            isActive('/admin/campaigns')
                                ? 'text-indigo-400'
                                : 'text-slate-500 group-hover:text-indigo-400'
                        "
                    ></i>
                    <span class="font-medium">Campagnes</span>
                </Link>
                <Link
                    href="/admin/no_users"
                    :class="[
                        isActive('/admin/campaigns')
                            ? 'bg-slate-800 text-white'
                            : 'hover:bg-slate-800 hover:text-white',
                    ]"
                    class="flex items-center p-3 rounded-xl transition-all duration-200 group"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-6 h-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z"
                        />
                    </svg>
                    <span class="font-medium">Activation des comptes</span>
                </Link>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <div
                    class="bg-slate-800/50 p-3 rounded-xl flex items-center gap-3"
                >
                    <div
                        class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center text-white font-bold text-xs"
                    >
                        AD
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-bold text-white truncate">
                            Administrateur
                        </p>
                        <p class="text-[10px] text-slate-500 truncate">
                            admin@wiplite.com
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

                <DropdownLink :href="route('logout')" method="post" as="button">
                    Log Out
                </DropdownLink>
                <div class="flex items-center gap-3">
                    <!-- Notification Button -->
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

                    <div class="h-8 w-[1px] bg-slate-200 mx-2"></div>

                    <button
                        class="flex items-center gap-2 hover:bg-slate-50 p-1 rounded-full transition-all"
                    >
                        <i class="pi pi-cog text-slate-400"></i>
                    </button>
                </div>
            </header>

            <!-- OverlayPanel épuré -->
            <OverlayPanel
                ref="op"
                style="width: 380px"
                class="shadow-2xl border-slate-200 rounded-2xl overflow-hidden"
            >
                <div class="flex flex-col">
                    <div
                        class="p-4 border-b border-slate-100 flex justify-between items-center"
                    >
                        <span class="font-bold text-slate-800"
                            >Notifications</span
                        >
                        <span
                            v-if="$page.props.auth.notifications.length"
                            class="text-[10px] bg-indigo-50 text-indigo-600 px-2 py-1 rounded-md font-bold uppercase"
                            >Nouveau</span
                        >
                    </div>

                    <div class="max-h-[400px] overflow-y-auto">
                        <div v-if="$page.props.auth.notifications.length > 0">
                            <div
                                v-for="notif in $page.props.auth.notifications"
                                :key="notif.id"
                                class="p-4 border-b border-slate-50 hover:bg-slate-50 cursor-pointer transition-all flex gap-4"
                                @click="markAsRead(notif.id)"
                            >
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-50 flex-shrink-0 flex items-center justify-center"
                                >
                                    <i class="pi pi-calendar text-blue-500"></i>
                                </div>
                                <div class="flex-1">
                                    <p
                                        class="text-sm text-slate-700 leading-snug mb-1"
                                    >
                                        {{ notif.data.message }}
                                    </p>
                                    <p
                                        class="text-[11px] text-slate-400 flex items-center italic"
                                    >
                                        <i
                                            class="pi pi-clock mr-1 text-[10px]"
                                        ></i>
                                        {{
                                            new Date(
                                                notif.created_at,
                                            ).toLocaleDateString()
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            v-else
                            class="p-12 text-center flex flex-col items-center"
                        >
                            <i
                                class="pi pi-bell-slash text-slate-200 text-4xl mb-3"
                            ></i>
                            <p class="text-slate-400 text-sm">
                                Tout est à jour !
                            </p>
                        </div>
                    </div>

                    <div
                        v-if="$page.props.auth.notifications.length > 0"
                        class="p-3 bg-slate-50 text-center"
                    >
                        <Link
                            href="/notifications"
                            class="text-xs text-indigo-600 font-bold hover:text-indigo-800"
                        >
                            VOIR TOUT L'HISTORIQUE
                        </Link>
                    </div>
                </div>
            </OverlayPanel>

            <!-- Main Page Content -->
            <main class="p-8 flex-1">
                <!-- Conteneur pour limiter la largeur du contenu et le rendre plus lisible -->
                <div class="max-w-7xl mx-auto">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<style>
/* Custom PrimeVue Badge Style pour coller à l'esprit épuré */
.p-badge.p-badge-danger {
    background: #ef4444;
    min-width: 1.2rem;
    height: 1.2rem;
    line-height: 1.2rem;
    font-size: 0.65rem;
    font-weight: 800;
}

/* On lisse les transitions de l'OverlayPanel */
.p-overlaypanel {
    border-radius: 16px !important;
}
.p-overlaypanel:before,
.p-overlaypanel:after {
    display: none !important; /* On enlève la petite flèche pour plus de modernité */
}
</style>
