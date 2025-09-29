<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import DataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    employes: Object,
    auth: Object,
});

const isAdmin = props.auth.user.roles.includes("admin");

const headers = [
    { text: "No", value: "no" },
    { text: "First Name", value: "first_name" },
    { text: "Last Name", value: "last_name" },
    { text: "Email", value: "email" },
    { text: "Phone", value: "phone" },
    { text: "Company", value: "company" },
    ...(isAdmin ? [{ text: "Action", value: "action", sortable: false }] : []),
];

const items = ref([]);
const serverOptions = ref({
    page: props.employes.current_page,
    rowsPerPage: props.employes.per_page,
});
const serverItemsLength = ref(props.employes.total);
const loading = ref(false);

console.log(items.value);

const mapEmployeData = (data) => {
    return data.data.map((employe, index) => ({
        no: (data.current_page - 1) * data.per_page + index + 1,
        id: employe.id,
        first_name: employe.first_name,
        last_name: employe.last_name,
        email: employe.email,
        phone: employe.phone,
        company: employe.company ?? "-",
    }));
};

items.value = mapEmployeData(props.employes);

watch(
    () => serverOptions.value.page,
    (newPage) => {
        if (newPage !== props.employes.current_page) {
            loading.value = true;
            router.visit(route("employes.index", { page: newPage }), {
                only: ["employes"],
                preserveState: true,
                preserveScroll: true,
                replace: false,
                onSuccess: () => {
                    loading.value = false;
                },
                onError: () => {
                    loading.value = false;
                },
            });
        }
    }
);

watch(
    () => props.employes,
    (newEmployes) => {
        items.value = mapEmployeData(newEmployes);
        serverOptions.value.page = newEmployes.current_page;
        serverItemsLength.value = newEmployes.total;
    },
    { deep: true }
);

const editEmploye = (id) => {
    router.get(
        route("employes.edit", id),
        { page: serverOptions.value.page },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

const deleteEmploye = (id) => {
    if (confirm("Are you sure you want to delete this employee?")) {
        router.delete(route("employes.destroy", id), {
            preserveState: true,
            preserveScroll: true,
        });
    }
};
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
                            v-if="isAdmin"
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
                            Add Employe
                        </Link>
                    </div>
                </div>

                <!-- Table Section -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Employe List
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <DataTable
                            :headers="headers"
                            :items="items"
                            v-model:server-options="serverOptions"
                            :server-items-length="serverItemsLength"
                            :loading="loading"
                            table-class-name="w-full"
                            header-text-direction="left"
                            body-text-direction="left"
                            alternating
                            :theme-color="'#3b82f6'"
                            buttons-pagination
                        >
                            <!-- Email -->
                            <template #item-email="{ email }">
                                <a
                                    :href="`mailto:${email}`"
                                    class="text-blue-600 hover:text-blue-800 hover:underline text-sm"
                                >
                                    {{ email }}
                                </a>
                            </template>

                            <!-- Actions -->
                            <template v-if="isAdmin" #item-action="{ id }">
                                <div class="flex space-x-2">
                                    <button
                                        @click="editEmploye(id)"
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
                                    </button>
                                    <button
                                        @click="deleteEmploye(id)"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-700 bg-red-50 rounded-md hover:bg-red-100 transition-colors duration-200"
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
                                    </button>
                                </div>
                            </template>
                        </DataTable>
                    </div>

                    <!-- Pagination Info -->
                    <div class="px-6 py-3 border-t border-gray-200 bg-gray-50">
                        <div class="text-sm text-gray-700 text-center">
                            Showing
                            <span class="font-medium">{{
                                employes.from || 0
                            }}</span>
                            to
                            <span class="font-medium">{{
                                employes.to || 0
                            }}</span>
                            of
                            <span class="font-medium">{{
                                employes.total
                            }}</span>
                            results
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Customize DataTable pagination */
.vue3-easy-data-table__main {
    border: none !important;
}

.vue3-easy-data-table__footer {
    padding: 16px 24px;
    background-color: #f9fafb;
    border-top: 1px solid #e5e7eb;
}
</style>
