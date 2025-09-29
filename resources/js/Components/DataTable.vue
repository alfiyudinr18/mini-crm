<template>
    <div class="uk-card uk-card-default">
        <div class="uk-card-body">
            <table class="uk-table uk-table-hover uk-table-divider">
                <thead>
                    <tr>
                        <th v-for="col in columns" :key="col.key">
                            {{ col.label }}
                        </th>
                        <th v-if="actions.length">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items" :key="item.id">
                        <td v-for="col in columns" :key="col.key">
                            <img
                                v-if="col.type === 'image' && item[col.key]"
                                :src="`/storage/${item[col.key]}`"
                                width="40"
                                height="40"
                                class="uk-border-circle"
                            />
                            <span v-else>{{ item[col.key] || "-" }}</span>
                        </td>
                        <td v-if="actions.length">
                            <Link
                                v-for="action in actions"
                                :key="action.name"
                                :as="action.method ? 'button' : 'a'"
                                :method="action.method"
                                :href="action.route(item)"
                                :class="`uk-button uk-button-small ${
                                    action.class || ''
                                }`"
                                @click="
                                    action.confirm
                                        ? (e) =>
                                              handleConfirm(
                                                  e,
                                                  action.confirmText
                                              )
                                        : undefined
                                "
                            >
                                <span :uk-icon="action.icon"></span>
                            </Link>
                        </td>
                    </tr>
                    <tr v-if="!items || !items.length">
                        <td
                            :colspan="columns.length + (actions.length ? 1 : 0)"
                            class="uk-text-center"
                        >
                            No data available
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div v-if="totalPages > 1" class="uk-margin-top">
                <ul class="uk-pagination uk-flex-center">
                    <li :class="{ 'uk-disabled': currentPage === 1 }">
                        <Link
                            :href="
                                currentPage === 1
                                    ? '#'
                                    : `${baseUrl}?page=${currentPage - 1}`
                            "
                            :preserve-state="true"
                            :preserve-scroll="true"
                        >
                            <span uk-icon="chevron-left"></span>
                        </Link>
                    </li>
                    <li
                        v-for="page in visiblePages"
                        :key="page"
                        :class="{ 'uk-active': page === currentPage }"
                    >
                        <Link
                            :href="`${baseUrl}?page=${page}`"
                            :preserve-state="true"
                            :preserve-scroll="true"
                        >
                            {{ page }}
                        </Link>
                    </li>
                    <li :class="{ 'uk-disabled': currentPage === totalPages }">
                        <Link
                            :href="
                                currentPage === totalPages
                                    ? '#'
                                    : `${baseUrl}?page=${currentPage + 1}`
                            "
                            :preserve-state="true"
                            :preserve-scroll="true"
                        >
                            <span uk-icon="chevron-right"></span>
                        </Link>
                    </li>
                </ul>

                <!-- Info Text -->
                <div class="uk-text-center uk-margin-small-top uk-text-muted">
                    <small>Page {{ currentPage }} of {{ totalPages }}</small>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    title: String,
    items: Array,
    columns: Array,
    actions: { type: Array, default: () => [] },
    canCreate: { type: Boolean, default: true },
    currentPage: { type: Number, default: 1 },
    totalPages: { type: Number, default: 1 },
    path: { type: String, default: "" },
});

const baseUrl = computed(() => {
    // Remove any existing query params from path
    return props.path.split("?")[0];
});

const handleConfirm = (e, text) => {
    if (!confirm(text || "Are you sure?")) {
        e.preventDefault();
    }
};

const visiblePages = computed(() => {
    const pages = [];
    const start = Math.max(1, props.currentPage - 2);
    const end = Math.min(props.totalPages, props.currentPage + 2);

    for (let i = start; i <= end; i++) {
        pages.push(i);
    }

    return pages;
});
</script>
