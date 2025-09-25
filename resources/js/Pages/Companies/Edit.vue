<script setup>
import { Head, useForm, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    company: Object,
});

const logoPreview = ref(null);

const form = useForm({
    name: props.company.name || "",
    email: props.company.email || "",
    website: props.company.website || "",
    logo: null,
});

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.logo = file;

        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
            logoPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const removeFile = () => {
    form.logo = null;
    logoPreview.value = null;
    // Reset file input
    const fileInput = document.getElementById("logo");
    if (fileInput) {
        fileInput.value = "";
    }
};

const submit = () => {
    form.put(route("companies.update", props.company.id));
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Edit Company" />

        <div class="min-h-screen bg-gray-50 py-8">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold text-gray-900">
                        Edit Company
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Update company information
                    </p>
                </div>

                <!-- Form Card -->
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-200"
                >
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            Company Information
                        </h3>
                    </div>

                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Company Name -->
                            <div>
                                <label
                                    for="name"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Company Name *
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    v-model="form.name"
                                    :class="[
                                        'w-full px-3 py-2 border rounded-md text-sm transition-colors',
                                        form.errors.name
                                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500'
                                            : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500',
                                    ]"
                                    placeholder="Enter company name"
                                />
                                <p
                                    v-if="form.errors.name"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.name }}
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

                            <!-- Website -->
                            <div>
                                <label
                                    for="website"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Website
                                </label>
                                <input
                                    type="url"
                                    id="website"
                                    v-model="form.website"
                                    :class="[
                                        'w-full px-3 py-2 border rounded-md text-sm transition-colors',
                                        form.errors.website
                                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500'
                                            : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500',
                                    ]"
                                    placeholder="https://example.com"
                                />
                                <p
                                    v-if="form.errors.website"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.website }}
                                </p>
                            </div>

                            <!-- Current Logo Display -->
                            <div
                                v-if="company.logo && !logoPreview"
                                class="mb-4"
                            >
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    Current Logo
                                </label>
                                <div class="flex items-center space-x-4">
                                    <img
                                        :src="`/storage/${company.logo}`"
                                        class="h-16 w-16 object-contain rounded-md border border-gray-200"
                                        alt="Current logo"
                                    />
                                    <div>
                                        <p class="text-sm text-gray-600">
                                            Current company logo
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Upload a new file to replace
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Logo Upload -->
                            <div>
                                <label
                                    for="logo"
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                >
                                    {{
                                        company.logo
                                            ? "Replace Logo"
                                            : "Upload Logo"
                                    }}
                                </label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors"
                                >
                                    <div class="space-y-1 text-center">
                                        <div v-if="!logoPreview">
                                            <svg
                                                class="mx-auto h-12 w-12 text-gray-400"
                                                stroke="currentColor"
                                                fill="none"
                                                viewBox="0 0 48 48"
                                            >
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                />
                                            </svg>
                                            <div
                                                class="flex text-sm text-gray-600"
                                            >
                                                <label
                                                    for="logo"
                                                    class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500"
                                                >
                                                    <span>Upload a file</span>
                                                    <input
                                                        id="logo"
                                                        type="file"
                                                        class="sr-only"
                                                        accept="image/*"
                                                        @change="
                                                            handleFileUpload
                                                        "
                                                    />
                                                </label>
                                                <p class="pl-1">
                                                    or drag and drop
                                                </p>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, GIF up to 2MB (min
                                                100x100px)
                                            </p>
                                        </div>
                                        <div v-else class="relative">
                                            <img
                                                :src="logoPreview"
                                                class="mx-auto h-32 w-32 object-contain rounded-md"
                                                alt="Logo preview"
                                            />
                                            <button
                                                type="button"
                                                @click="removeFile"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"
                                                    />
                                                </svg>
                                            </button>
                                            <p
                                                class="mt-2 text-sm text-gray-500"
                                            >
                                                New logo preview
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <p
                                    v-if="form.errors.logo"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.logo }}
                                </p>
                            </div>

                            <!-- Form Actions -->
                            <div
                                class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200"
                            >
                                <Link
                                    :href="route('companies.index')"
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
                                            ? "Updating..."
                                            : "Update Company"
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
