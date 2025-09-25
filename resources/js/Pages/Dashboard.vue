<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useAuthStore } from "@/stores/auth";

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            companies: 0,
            employes: 0,
        }),
    },
});

const authStore = useAuthStore();
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="uk-heading-small uk-margin-remove">Dashboard</h2>
            <p class="uk-text-meta uk-margin-remove-top">
                Welcome back, {{ authStore.user?.name }}!
            </p>
        </template>

        <div class="uk-container">
            <!-- Statistics Cards -->
        </div>
    </AuthenticatedLayout>
</template>
