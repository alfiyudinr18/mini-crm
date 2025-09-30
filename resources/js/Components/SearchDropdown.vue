<template>
    <div class="relative" ref="dropdownRef">
        <label
            v-if="label"
            :for="inputId"
            class="block text-sm font-medium text-gray-700 mb-2"
        >
            {{ label }}
        </label>

        <div class="relative">
            <button
                type="button"
                @click="toggleDropdown"
                :class="[
                    'w-full px-3 py-2 border rounded-md text-sm transition-colors text-left flex items-center justify-between',
                    error
                        ? 'border-red-300 focus:border-red-500 focus:ring-red-500'
                        : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500',
                    isOpen ? 'ring-2 ring-blue-500 ring-opacity-50' : '',
                ]"
            >
                <span
                    :class="selectedOption ? 'text-gray-900' : 'text-gray-400'"
                >
                    {{
                        selectedOption
                            ? selectedOption[optionLabel]
                            : placeholder
                    }}
                </span>
                <svg
                    class="w-5 h-5 text-gray-400 transition-transform"
                    :class="{
                        'transform rotate-180': isOpen && position !== 'top',
                        'transform rotate-0': isOpen && position === 'top',
                    }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>
            </button>

            <transition
                enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
            >
                <div
                    v-show="isOpen"
                    :class="{
                        // Kelas dasar
                        'absolute z-50 w-full bg-white border border-gray-300 rounded-md shadow-lg': true,
                        // Kelas untuk posisi 'top'
                        'top-auto bottom-full mb-1': position === 'top',
                        // Kelas untuk posisi 'bottom' (default)
                        'mt-1': position === 'bottom',
                    }"
                >
                    <div class="p-2 border-b border-gray-200">
                        <input
                            ref="searchInput"
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            @click.stop
                        />
                    </div>

                    <div class="max-h-60 overflow-y-auto">
                        <button
                            v-for="option in filteredOptions"
                            :key="option[optionValue]"
                            type="button"
                            @click="selectOption(option)"
                            class="w-full px-3 py-2 text-left text-sm hover:bg-blue-50 transition-colors flex items-center justify-between"
                            :class="{
                                'bg-blue-100 text-blue-900':
                                    modelValue === option[optionValue],
                            }"
                        >
                            <span>{{ option[optionLabel] }}</span>
                            <svg
                                v-if="modelValue === option[optionValue]"
                                class="w-5 h-5 text-blue-600"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>

                        <div
                            v-if="filteredOptions.length === 0"
                            class="px-3 py-4 text-sm text-gray-500 text-center"
                        >
                            No results found
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <p v-if="error" class="mt-1 text-sm text-red-600">
            {{ error }}
        </p>
    </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted, nextTick } from "vue";

const props = defineProps({
    modelValue: {
        type: [String, Number, null],
        default: null,
    },
    options: {
        type: Array,
        required: true,
        default: () => [],
    },
    optionValue: {
        type: String,
        default: "id",
    },
    optionLabel: {
        type: String,
        default: "name",
    },
    label: {
        type: String,
        default: "",
    },
    placeholder: {
        type: String,
        default: "-- Select option --",
    },
    error: {
        type: String,
        default: "",
    },
    inputId: {
        type: String,
        default: "searchable-dropdown",
    },
    position: {
        type: String,
        default: "bottom", // Nilai default: 'bottom'
        validator: (value) => ["top", "bottom"].includes(value),
    },
});

const emit = defineEmits(["update:modelValue"]);

const dropdownRef = ref(null);
const searchInput = ref(null);
const isOpen = ref(false);
const searchQuery = ref("");

const selectedOption = computed(() => {
    return props.options.find(
        (option) => option[props.optionValue] === props.modelValue
    );
});

const filteredOptions = computed(() => {
    if (!searchQuery.value) {
        return props.options;
    }

    const query = searchQuery.value.toLowerCase();
    return props.options.filter((option) =>
        option[props.optionLabel].toLowerCase().includes(query)
    );
});

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
    if (isOpen.value) {
        nextTick(() => {
            searchInput.value?.focus();
        });
    }
};

const selectOption = (option) => {
    emit("update:modelValue", option[props.optionValue]);
    isOpen.value = false;
    searchQuery.value = "";
};

const handleClickOutside = (event) => {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        isOpen.value = false;
        searchQuery.value = "";
    }
};

watch(isOpen, (newVal) => {
    if (!newVal) {
        searchQuery.value = "";
    }
});

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>
