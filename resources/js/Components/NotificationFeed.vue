<script setup>
import { router } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Badge from 'primevue/badge';

defineProps({ notifications: Array });

const markAsRead = (id) => {
    router.post(`/notifications/${id}/read`);
};
</script>

<template>
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg border">
        <div class="p-3 border-b font-bold flex justify-between items-center">
            Notifications 
            <Badge :value="notifications.length" severity="danger"></Badge>
        </div>
        <div class="max-h-64 overflow-y-auto">
            <div v-for="n in notifications" :key="n.id" 
                 class="p-3 border-b hover:bg-gray-50 flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-800">{{ n.data.message }}</p>
                    <span class="text-xs text-gray-500">{{ n.created_at }}</span>
                </div>
                <Button icon="pi pi-check" class="p-button-rounded p-button-text p-button-sm" 
                        @click="markAsRead(n.id)" />
            </div>
            <div v-if="notifications.length === 0" class="p-4 text-center text-gray-400 text-sm">
                Aucune notification
            </div>
        </div>
    </div>
</template>