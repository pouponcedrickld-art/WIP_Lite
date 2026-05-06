<script setup>
defineProps({
    title: String,
    value: [String, Number],
    icon: String,
    iconBg: String,
    iconColor: String
});
</script>

<template>
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">{{ title }}</p>
                <h3 class="text-3xl font-black text-slate-800">{{ value }}</h3>
            </div>
            <div :class="[iconBg, iconColor]" class="w-12 h-12 rounded-xl flex items-center justify-center">
                <i :class="['pi', icon]" class="text-xl"></i>
            </div>
        </div>
    </div>
</template>