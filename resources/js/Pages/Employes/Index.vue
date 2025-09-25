<script setup>
import { Link } from "@inertiajs/vue3";
import DataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    employes: Object,
});

// Headers untuk DataTable
const headers = [
    { text: "ID", value: "id" },
    { text: "First Name", value: "first_name" },
    { text: "Last Name", value: "last_name" },
    { text: "Email", value: "email" },
    { text: "Phone", value: "phone" },
    { text: "Company", value: "company" },
    { text: "Action", value: "action", sortable: false },
];

// Mapping data employes ke items DataTable
const items = props.employes.data.map((employes) => ({
    id: employes.id,
    first_name: employes.first_name,
    last_name: employes.last_name,
    email: employes.email,
    phone: employes.phone,
    company: employes.company ?? "-", // kalau null kasih strip
    action: employes.id,
}));
</script>

<template>
    <AuthenticatedLayout>
        <div class="min-h-screen bg-gray-50 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6"
                >
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">
                                Employes
                            </h1>
                            <p class="text-sm text-gray-600 mt-1">
                                Manage your Employes information
                            </p>
                        </div>
                        <Link
                            :href="route('employes.create')"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors duration-200"
                        >
                            <svg
                                class="w-4 h-4 mr-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>
                            Add employe
                        </Link>
                    </div>
                </div>

                <!-- Table Section -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            employe List
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <DataTable
                            :headers="headers"
                            :items="items"
                            :rows-per-page="10"
                            table-class-name="w-full"
                            header-text-direction="left"
                            body-text-direction="left"
                            alternating
                            :theme-color="'#3b82f6'"
                        >
                            <!-- Custom cell untuk logo -->
                            <template #item-logo="{ logo }">
                                <div class="flex justify-center">
                                    <div
                                        v-if="logo"
                                        class="w-10 h-10 rounded-md overflow-hidden border border-gray-200"
                                    >
                                        <img
                                            :src="logo"
                                            class="w-full h-full object-cover"
                                            alt="employe Logo"
                                        />
                                    </div>
                                    <div
                                        v-else
                                        class="w-10 h-10 bg-gray-100 rounded-md flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>
                                    </div>
                                </div>
                            </template>

                            <!-- Custom cell untuk website -->
                            <template #item-website="{ website }">
                                <a
                                    v-if="website"
                                    :href="
                                        website.startsWith('http')
                                            ? website
                                            : `https://${website}`
                                    "
                                    target="_blank"
                                    class="text-blue-600 hover:text-blue-800 hover:underline text-sm"
                                >
                                    {{ website }}
                                </a>
                                <span v-else class="text-gray-400 text-sm"
                                    >-</span
                                >
                            </template>

                            <!-- Custom cell untuk email -->
                            <template #item-email="{ email }">
                                <a
                                    :href="`mailto:${email}`"
                                    class="text-blue-600 hover:text-blue-800 hover:underline text-sm"
                                >
                                    {{ email }}
                                </a>
                            </template>

                            <!-- Custom cell untuk action -->
                            <template #item-action="{ action }">
                                <div class="flex space-x-2">
                                    <Link
                                        :href="route('employes.edit', action)"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-700 bg-blue-50 rounded-md hover:bg-blue-100 transition-colors duration-200"
                                    >
                                        <svg
                                            class="w-3 h-3 mr-1"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                            />
                                        </svg>
                                        Edit
                                    </Link>
                                    <Link
                                        as="button"
                                        method="delete"
                                        :href="
                                            route('employes.destroy', action)
                                        "
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-700 bg-red-50 rounded-md hover:bg-red-100 transition-colors duration-200"
                                        @click="
                                            (e) => {
                                                if (
                                                    !confirm(
                                                        'Are you sure you want to delete this employe?'
                                                    )
                                                ) {
                                                    e.preventDefault();
                                                }
                                            }
                                        "
                                    >
                                        <svg
                                            class="w-3 h-3 mr-1"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
                                        </svg>
                                        Delete
                                    </Link>
                                </div>
                            </template>
                        </DataTable>
                    </div>
                </div>

                <!-- Pagination Info (jika diperlukan) -->
                <div v-if="employes.total > employes.per_page" class="mt-6">
                    <div
                        class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200"
                    >
                        <div class="text-sm text-gray-700 text-center">
                            Showing {{ employes.from }} to {{ employes.to }} of
                            {{ employes.total }} results
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
