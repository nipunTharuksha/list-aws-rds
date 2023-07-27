<template>
    <div>
        <div class="bg-white rounded shadow-sm ">
            <div class="mt-4 overflow-x-auto md:overflow-x-hidden">
                <table class="w-full whitespace-nowrap ">
                    <thead class="bg-gray-100 ">
                    <tr class="border-y-1">
                        <th v-for="(header,index) in tableHeaders" :key="index"
                            class="py-5 px-6 text-sm font-normal  text-left  "
                            scope="col">
                            {{ header }}
                        </th>
                    </tr>
                    </thead>
                    <tbody ref="refTable" class="relative">

                    <Tr v-if="numberOfRows === 0">
                        <template #td>
                            <td :colspan="tableHeaders.length">
                                <div
                                    class="flex justify-center p-4 text-sm text-gray-700 rounded-lg dark:bg-gray-700 dark:text-gray-300"
                                    role="alert">
                                    <svg class="inline flex-shrink-0 mr-3 w-5 h-5" fill="currentColor"
                                         viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path clip-rule="evenodd"
                                              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                              fill-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <span class="font-medium">No records can be found!</span>
                                    </div>
                                </div>
                            </td>
                        </template>
                    </Tr>
                    <slot name="tbody">

                    </slot>

                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="paginationData" class="bg-white rounded shadow-sm my-2">
            <Paginate :current-page="paginationData.current_page || 1"
                      :has-more-pages="paginationData.has_more_pages || false"
                      :per-page="paginationData.per_page || 10" :total="paginationData.total || 0"
                      :total-pages="paginationData.total_pages || 0"
                      @pagechanged="(page) => emits('pageChanged',page)"
                      @perpageChanged="(perPage) => emits('perpageChanged',perPage)"/>
        </div>
    </div>
</template>

<script setup>

import {inject, reactive, ref, watch} from "vue";
import Paginate from '../Pagination/Paginate'
import Tr from './Tr'
import Td from './Td'

const props = defineProps(['tableHeaders', 'tableBodyData', 'headerButtonTitle', 'loading', 'paginationData', 'numberOfRows'])
const emits = defineEmits(['headerButtonClicked', 'searching', 'pageChanged', 'perpageChanged'])
const refTable = ref(null)

const $loading = inject('$loading')
const loader = ref(null)

const inputs = reactive([
    {
        placeholder: "Search",
        key: 'search',
        value: "",
        type: 'search',
        name: 'location name',
        classes: 'mb-0 px-0'
    }
])

watch(() => props.loading, (value) => {
    if (value) loader.value = $loading.show({container: refTable.value})
    else if (!value && loader) {
        loader.value.hide()
        loader.value = null
    }
})


</script>

<style scoped>

</style>
