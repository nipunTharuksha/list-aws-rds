<template>
    <div class="flex justify-end">
        <ul class="pagination bg-white p-2 shadow-sm rounded">
            <li class="pagination-item">
				<span
                    v-if="isInFirstPage"
                    class="rounded-l rounded-sm border border-gray-100 px-3 py-2 cursor-not-allowed no-underline text-gray-600 h-10"
                >&laquo;</span>
                <a
                    v-else
                    class="rounded-l rounded-sm border-t border-b border-l border-gray-100 px-3 py-2 text-gray-600 hover:bg-gray-100 no-underline"
                    href="#"
                    rel="prev"
                    role="button"
                    @click.prevent="onClickFirstPage"
                >
                    &laquo;
                </a>
            </li>

            <li class="pagination-item">
                <button
                    :class="{'cursor-not-allowed': isInFirstPage}"
                    :disabled="isInFirstPage"
                    aria-label="Go to previous page"
                    class="rounded-sm border border-gray-100 px-3 py-2 hover:bg-gray-100 text-gray-600 no-underline mx-2 text-sm"
                    type="button"
                    @click="onClickPreviousPage"
                >Previous
                </button>
            </li>

            <li
                v-for="page in pages"
                :key="page.name"
                class="pagination-item"
            >
				<span
                    v-if="isPageActive(page.name)"
                    class="rounded-sm border border-blue-100 px-3 py-2 bg-blue-100 no-underline text-blue-500 cursor-not-allowed mx-2"
                >{{ page.name }}</span>
                <a
                    v-else
                    class="rounded-sm border border-gray-100 px-3 py-2 hover:bg-gray-100 text-gray-600 no-underline mx-2"
                    href="#"
                    role="button"
                    @click.prevent="onClickPage(page.name)"
                >{{ page.name }}</a>
                <!-- <button
                    type="button"
                    @click="onClickPage(page.name)"
                    :disabled="page.isDisabled"
                    :class="{ active: isPageActive(page.name) }"
                >{{ page.name }}</button> -->
            </li>

            <li class="pagination-item">
                <button
                    :class="{'cursor-not-allowed': isInLastPage || totalPages === currentPage}"
                    :disabled="isInLastPage"
                    aria-label="Go to next page"
                    class="rounded-sm border border-gray-100 px-3 py-2 hover:bg-gray-100 text-gray-600 no-underline mx-2 text-sm"
                    type="button"
                    @click="onClickNextPage"
                >Next
                </button>
            </li>

            <li class="pagination-item">
                <!-- <button
                    type="button"
                    @click="onClickLastPage"
                    :disabled="isInLastPage"
                    aria-label="Go to last page"
                >Last</button> -->
                <a
                    v-if="hasMorePages"
                    class="rounded-r rounded-sm border border-gray-100 px-3 py-2 hover:bg-gray-100 text-gray-600 no-underline"
                    href="#"
                    rel="next"
                    role="button"
                    @click.prevent="onClickLastPage"
                >&raquo;</a>
                <span
                    v-else
                    class="rounded-r rounded-sm border border-gray-100 px-3 py-2 hover:bg-gray-100 text-gray-600 no-underline cursor-not-allowed"
                >&raquo;</span>
            </li>
        </ul>
    </div>
</template>

<script setup>
import {computed} from "vue"

const props = defineProps({
    maxVisibleButtons: {
        type: Number,
        required: false,
        default: 3
    },
    totalPages: {
        type: Number,
        required: true
    },
    total: {
        type: Number,
        required: true
    },
    perPage: {
        type: Number,
        required: true
    },
    currentPage: {
        type: Number,
        required: true
    },
    hasMorePages: {
        type: Boolean,
        required: true
    },
    showPerPage: {
        type: Boolean,
        default: true
    }
})

const startPage = computed(() => {
    if (props.currentPage === 1) {
        return 1;
    }

    if (props.currentPage === props.totalPages) {
        return props.totalPages - props.maxVisibleButtons + 1;
    }

    return props.currentPage - 1;
})

const endPage = computed(() => {
    return Math.min(
        startPage.value + props.maxVisibleButtons - 1,
        props.totalPages
    );
})

const pages = computed(() => {
    const range = [];

    for (let i = startPage.value; i <= endPage.value; i += 1) {
        range.push({
            name: i,
            isDisabled: i === props.currentPage
        });
    }

    return range;
})

const isInFirstPage = computed(() => {
    return props.currentPage === 1;
})

const isInLastPage = computed(() => {
    return props.currentPage === props.totalPages;
})

const emits = defineEmits(['pagechanged', 'perpageChanged'])

function onClickFirstPage() {
    emits("pagechanged", 1);
}

function onClickPreviousPage() {
    emits("pagechanged", props.currentPage - 1);
}

function onClickPage(page) {
    emits("pagechanged", page);
}

function onClickNextPage() {
    emits("pagechanged", props.currentPage + 1);
}

function onClickLastPage() {
    emits("pagechanged", props.totalPages);
}

function isPageActive(page) {
    return props.currentPage === page;
}
</script>

<style scoped>
.pagination {
    list-style-type: none;
}

.pagination-item {
    display: inline-block;
}

.active {
    @apply .border-t .border-b .border-l .border-blue-100 .px-3 .py-2 .bg-blue-100 .no-underline .text-blue-500 .text-sm;
}
</style>
