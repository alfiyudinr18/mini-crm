<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useAuthStore } from "@/stores/auth";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalCompanies: 0,
            totalEmployees: 0,
            recentCompanies: 0,
            recentEmployees: 0,
            averageEmployeesPerCompany: 0,
            companiesWithoutEmployees: 0,
        }),
    },
});

const authStore = useAuthStore();

const mainStats = [
    {
        title: "Total Companies",
        value: props.stats.totalCompanies,
        icon: "🏢",
        color: "bg-blue-500",
        lightColor: "bg-blue-50",
        textColor: "text-blue-600",
        description: "All registered companies",
    },
    {
        title: "Total Employees",
        value: props.stats.totalEmployees,
        icon: "👥",
        color: "bg-green-500",
        lightColor: "bg-green-50",
        textColor: "text-green-600",
        description: "All registered employees",
    },
    {
        title: "New Companies",
        value: props.stats.recentCompanies,
        icon: "🆕",
        color: "bg-purple-500",
        lightColor: "bg-purple-50",
        textColor: "text-purple-600",
        description: "Added in last 30 days",
    },
    {
        title: "New Employees",
        value: props.stats.recentEmployees,
        icon: "✨",
        color: "bg-orange-500",
        lightColor: "bg-orange-50",
        textColor: "text-orange-600",
        description: "Added in last 30 days",
    },
];

const additionalStats = [
    {
        title: "Avg Employees/Company",
        value: props.stats.averageEmployeesPerCompany,
        icon: "📊",
        color: "bg-indigo-500",
        lightColor: "bg-indigo-50",
    },
    {
        title: "Companies Without Employees",
        value: props.stats.companiesWithoutEmployees,
        icon: "⚠️",
        color: "bg-red-500",
        lightColor: "bg-red-50",
    },
];
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <div class="space-y-1">
                <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
                <p class="text-sm text-gray-500">
                    Welcome back, {{ authStore.user?.name }}!
                </p>
            </div>
        </template>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Main Statistics Cards -->
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8"
            >
                <div
                    v-for="(stat, index) in mainStats"
                    :key="index"
                    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden transform hover:-translate-y-1"
                >
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div :class="[stat.lightColor, 'p-3 rounded-full']">
                                <span class="text-2xl">{{ stat.icon }}</span>
                            </div>
                            <div
                                :class="[stat.color, 'w-1 h-16 rounded-full']"
                            ></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">
                                {{ stat.title }}
                            </p>
                            <p class="text-3xl font-bold text-gray-900 mb-1">
                                {{ stat.value }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ stat.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div
                    v-for="(stat, index) in additionalStats"
                    :key="index"
                    class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300"
                >
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 mb-2">
                                {{ stat.title }}
                            </p>
                            <p class="text-4xl font-bold text-gray-900">
                                {{ stat.value }}
                            </p>
                        </div>
                        <div :class="[stat.lightColor, 'p-4 rounded-full']">
                            <span class="text-3xl">{{ stat.icon }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">
                    Quick Actions
                </h3>
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                >
                    <a
                        href="/companies/create"
                        class="flex items-center justify-center px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200 font-medium"
                    >
                        <span class="mr-2">➕</span>
                        Add Company
                    </a>
                    <a
                        href="/employes/create"
                        class="flex items-center justify-center px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-200 font-medium"
                    >
                        <span class="mr-2">👤</span>
                        Add Employee
                    </a>
                    <a
                        href="/companies"
                        class="flex items-center justify-center px-4 py-3 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition-colors duration-200 font-medium"
                    >
                        <span class="mr-2">📋</span>
                        View Companies
                    </a>
                    <a
                        href="/employes"
                        class="flex items-center justify-center px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors duration-200 font-medium"
                    >
                        <span class="mr-2">📊</span>
                        View Employees
                    </a>
                </div>
            </div>

            <!-- System Overview -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">
                    System Overview
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border border-green-200"
                    >
                        <div class="flex items-center">
                            <div
                                class="w-3 h-3 bg-green-500 rounded-full mr-3 animate-pulse"
                            ></div>
                            <span class="text-gray-700 font-medium"
                                >System Status</span
                            >
                        </div>
                        <span class="text-green-600 font-semibold">Active</span>
                    </div>
                    <div
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200"
                    >
                        <div class="flex items-center">
                            <div
                                class="w-3 h-3 bg-blue-500 rounded-full mr-3 animate-pulse"
                            ></div>
                            <span class="text-gray-700 font-medium"
                                >Database</span
                            >
                        </div>
                        <span class="text-blue-600 font-semibold"
                            >Connected</span
                        >
                    </div>
                    <div
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg border border-purple-200"
                    >
                        <div class="flex items-center">
                            <div
                                class="w-3 h-3 bg-purple-500 rounded-full mr-3 animate-pulse"
                            ></div>
                            <span class="text-gray-700 font-medium"
                                >User Role</span
                            >
                        </div>
                        <span
                            class="text-purple-600 font-semibold capitalize"
                            >{{ authStore.user?.roles?.[0] || "User" }}</span
                        >
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
