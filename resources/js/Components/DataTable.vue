<template>
    <div class="uk-card uk-card-default">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom">
                        {{ title }}
                    </h3>
                </div>
                <div class="uk-width-auto" v-if="canCreate">
                    <button
                        class="uk-button uk-button-primary uk-button-small"
                        @click="$emit('create')"
                    >
                        <span uk-icon="plus"></span> Add {{ title }}
                    </button>
                </div>
            </div>
        </div>

        <div class="uk-card-body uk-padding-small">
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-hover uk-table-divider">
                    <thead>
                        <tr>
                            <th v-for="column in columns" :key="column.key">
                                {{ column.label }}
                            </th>
                            <th v-if="actions.length > 0">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in data.data" :key="item.id">
                            <td v-for="column in columns" :key="column.key">
                                <template
                                    v-if="
                                        column.type === 'image' &&
                                        item[column.key]
                                    "
                                >
                                    <img
                                        :src="`/storage/${item[column.key]}`"
                                        :alt="column.label"
                                        class="uk-border-circle"
                                        width="40"
                                        height="40"
                                    />
                                </template>
                                <template v-else>
                                    {{ item[column.key] || "-" }}
                                </template>
                            </td>
                            <td v-if="actions.length > 0">
                                <div class="uk-button-group">
                                    <template
                                        v-for="action in actions"
                                        :key="action.name"
                                    >
                                        <button
                                            v-if="
                                                !action.permission ||
                                                hasPermission(action.permission)
                                            "
                                            :class="`uk-button uk-button-small ${
                                                action.class ||
                                                'uk-button-default'
                                            }`"
                                            @click="$emit(action.name, item)"
                                        >
                                            <span :uk-icon="action.icon"></span>
                                        </button>
                                    </template>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="data.data.length === 0">
                            <td
                                :colspan="
                                    columns.length +
                                    (actions.length > 0 ? 1 : 0)
                                "
                                class="uk-text-center"
                            >
                                No data available
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="data.last_page > 1" class="uk-margin-top">
                <ul class="uk-pagination uk-flex-center">
                    <li :class="{ 'uk-disabled': !data.prev_page_url }">
                        <Link
                            :href="data.prev_page_url || '#'"
                            class="uk-link-reset"
                        >
                            <span uk-icon="chevron-left"></span>
                        </Link>
                    </li>
                    <li
                        v-for="page in paginationPages"
                        :key="page"
                        :class="{ 'uk-active': page === data.current_page }"
                    >
                        <Link
                            :href="data.path + '?page=' + page"
                            class="uk-link-reset"
                            >{{ page }}</Link
                        >
                    </li>
                    <li :class="{ 'uk-disabled': !data.next_page_url }">
                        <Link
                            :href="data.next_page_url || '#'"
                            class="uk-link-reset"
                        >
                            <span uk-icon="chevron-right"></span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { useAuthStore } from "../stores/auth";

const props = defineProps({
    title: String,
    data: Object,
    columns: Array,
    actions: {
        type: Array,
        default: () => [],
    },
    canCreate: {
        type: Boolean,
        default: true,
    },
});

defineEmits(["create", "edit", "show", "delete"]);

const authStore = useAuthStore();

const hasPermission = (permission) => {
    return authStore.hasPermission(permission);
};

const paginationPages = computed(() => {
    const pages = [];
    const current = props.data.current_page;
    const last = props.data.last_page;
    const delta = 2;

    for (
        let i = Math.max(1, current - delta);
        i <= Math.min(last, current + delta);
        i++
    ) {
        pages.push(i);
    }

    return pages;
});
</script>
