<template>
    <div class="px-2 md:w-1/4 w-full">

        <select
            @change="$emit('regionSelected',selectedRegion)"
            v-model="selectedRegion"
            class="w-full text-gray-600 dark:text-gray-400 focus:outline-none focus:border
                       focus:border-indigo-700 dark:focus:border-indigo-700 dark:border-gray-700
                        dark:bg-gray-800 bg-white font-normal  flex items-center pl-3 text-sm
                         border-gray-300 rounded border shadow capitalize"
        >
            <option selected value="">All regions</option>
            <option v-for="(option,index) in regions" :key="index"
                    :value="option">
                {{ option }}
            </option>
        </select>


    </div>
</template>

<script setup>
import useRegions from '../../../composables/regions'
import {ref, onMounted, watch} from "vue";
const emit = defineEmits(['regionSelected'])


const {index, regions} = useRegions()
const selectedRegion = ref("")
onMounted(async () => {
    await index()
})

/*watch(() => selectedRegion, (value) => {
    emits('regionSelected')
})*/
</script>

<style scoped>

</style>
