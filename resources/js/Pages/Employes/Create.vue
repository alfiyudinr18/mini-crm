<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SearchDropdown from "@/Components/SearchDropdown.vue";

const props = defineProps({
    companies: Array,
});

const form = useForm({
    first_name: "",
    last_name: "",
    email: "",
    phone: "",
    company_id: "",
});

const submit = () => {
    form.post(route("employes.store"));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Create Employe" />

        <div class="min-h-screen bg-gray-50 py-8">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        Create Employe
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Add a new employe to your database
                    </p>
                </div>

                <!-- Form Card -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Employe Information
                        </h3>
                    </div>

                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- First Name -->
                            <div>
                                <label
                                    for="first_name"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    First Name *
                                </label>
                                <input
                                    type="text"
                                    id="first_name"
                                    v-model="form.first_name"
                                    :class="[
                                        'w-full px-3 py-2 border rounded-md text-sm transition-colors',
                                        form.errors.first_name
                                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500'
                                            : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500',
                                    ]"
                                    placeholder="Enter first name"
                                />
                                <p
                                    v-if="form.errors.first_name"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.first_name }}
                                </p>
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label
                                    for="last_name"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Last Name *
                                </label>
                                <input
                                    type="text"
                                    id="last_name"
                                    v-model="form.last_name"
                                    :class="[
                                        'w-full px-3 py-2 border rounded-md text-sm transition-colors',
                                        form.errors.last_name
                                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500'
                                            : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500',
                                    ]"
                                    placeholder="Enter last name"
                                />
                                <p
                                    v-if="form.errors.last_name"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.last_name }}
                                </p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label
                                    for="email"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Email
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    v-model="form.email"
                                    :class="[
                                        'w-full px-3 py-2 border rounded-md text-sm transition-colors',
                                        form.errors.email
                                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500'
                                            : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500',
                                    ]"
                                    placeholder="Enter email address"
                                />
                                <p
                                    v-if="form.errors.email"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.email }}
                                </p>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label
                                    for="phone"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Phone
                                </label>
                                <input
                                    type="tel"
                                    id="phone"
                                    v-model="form.phone"
                                    :class="[
                                        'w-full px-3 py-2 border rounded-md text-sm transition-colors',
                                        form.errors.phone
                                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500'
                                            : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500',
                                    ]"
                                    placeholder="Enter phone number"
                                />
                                <p
                                    v-if="form.errors.phone"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.phone }}
                                </p>
                            </div>

                            <!-- Company -->
                            <div>
                                <SearchDropdown
                                    v-model="form.company_id"
                                    :options="companies"
                                    option-value="id"
                                    option-label="name"
                                    label="Company"
                                    placeholder="-- Select company --"
                                    :error="form.errors.company_id"
                                    input-id="company_id"
                                    position="top"
                                />
                                <p
                                    v-if="form.errors.company_id"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.company_id }}
                                </p>
                            </div>

                            <!-- Actions -->
                            <div
                                class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200"
                            >
                                <Link
                                    :href="route('employes.index')"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 transition-colors duration-200"
                                >
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
                                >
                                    <svg
                                        v-if="form.processing"
                                        class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"
                                        ></circle>
                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        ></path>
                                    </svg>
                                    {{
                                        form.processing
                                            ? "Creating..."
                                            : "Create Employe"
                                    }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
