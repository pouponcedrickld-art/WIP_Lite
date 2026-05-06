<script setup>
import Dropdown from "@/Components/Dropdown.vue";
</script>

<template>
    <h1>Dashboard admin</h1>

    <DropdownLink :href="route('logout')" method="post" as="button">
        Log Out
    </DropdownLink>
</template>

<style scoped></style>
