<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    employe: Object,
    companies: Array, // buat dropdown pilih company
});

const photoPreview = ref(null);

const form = useForm({
    first_name: props.employe.first_name || "",
    last_name: props.employe.last_name || "",
    email: props.employe.email || "",
    phone: props.employe.phone || "",
    company_id: props.employe.company_id || "",
});

const submit = () => {
    form.put(route("employes.update", props.employe.id));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Edit Employe" />

        <div class="min-h-screen bg-gray-50 py-8">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        Edit Employe
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Update employe information
                    </p>
                </div>

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
                                        'w-full px-3 py-2 border rounded-md text-sm',
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
                                    Last Name
                                </label>
                                <input
                                    type="text"
                                    id="last_name"
                                    v-model="form.last_name"
                                    :class="[
                                        'w-full px-3 py-2 border rounded-md text-sm',
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
                                        'w-full px-3 py-2 border rounded-md text-sm',
                                        form.errors.email
                                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500'
                                            : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500',
                                    ]"
                                    placeholder="Enter email"
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
                                    type="text"
                                    id="phone"
                                    v-model="form.phone"
                                    :class="[
                                        'w-full px-3 py-2 border rounded-md text-sm',
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

                            <!-- Company Dropdown -->
                            <div>
                                <label
                                    for="company_id"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Company *
                                </label>
                                <select
                                    id="company_id"
                                    v-model="form.company_id"
                                    :class="[
                                        'w-full px-3 py-2 border rounded-md text-sm',
                                        form.errors.company_id
                                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500'
                                            : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500',
                                    ]"
                                >
                                    <option value="">Select company</option>
                                    <option
                                        v-for="company in companies"
                                        :key="company.id"
                                        :value="company.id"
                                    >
                                        {{ company.name }}
                                    </option>
                                </select>
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
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200"
                                >
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 disabled:opacity-50"
                                >
                                    {{
                                        form.processing
                                            ? "Updating..."
                                            : "Update Employe"
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
