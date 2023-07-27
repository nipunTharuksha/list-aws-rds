<template>
    <div>

        <div class="flex justify-between">
            <button
                @click="index(selectedRegionValue)"
                class="hover:bg-indigo-600 hover:text-white border border-indigo-600 text-blue-600 focus:ring-2
                  focus:ring-offset-2 focus:ring-indigo-600 px-6  focus:outline-none rounded w-full md:w-auto ">
                    <RefreshIcon/>
            </button>

            <RegionDropDown @regionSelected="regionSelected"/>

        </div>

        <Table
            :table-headers="tableHeaders"
            :paginationData="pagination"
            :number-of-rows="instances.length"
            :loading="loading"
        >
            <template #tbody>
                <Tr v-for="(item,index) in instances" :key="index">
                    <template #td>
                        <Td :value="`#${((pagination.current_page - 1) * pagination.per_page) + index + 1}`"/>
                        <Td>
                            <template #content>
                                <router-link :to="`/dashboard/rds/${item.DBInstanceIdentifier}/${item.AvailabilityZone?.substring(0, item.AvailabilityZone.length - 1)}`">
                                <p class="text-sm font-normal underline text-blue-600 hover:text-blue-800 visited:text-purple-600 cursor-pointer">
                                {{item.DBInstanceIdentifier}}
                                </p>
                                </router-link>
                            </template>
                        </Td>
                        <Td>
                            <template #content>
                                <div class="capitalize"
                                     :class="{'text-green-600' :item.DBInstanceStatus === 'available',
                                               'text-red-600' :item.DBInstanceStatus === 'stopped'}">
                                    <p class="text-sm font-normal ">
                                        <CheckIcon v-if="item.DBInstanceStatus === 'available'" class=" mr-1 mb-1"/>
                                        {{ item.DBInstanceStatus }}
                                    </p>
                                </div>
                            </template>
                        </Td>
                        <Td :value="item.AvailabilityZone"/>
                        <Td :value="item.Engine"/>
                        <Td :value="item.DBInstanceClass"/>

                        <Td>
                            <template #content>
                                <div class="flex items-center">

                                    <button
                                        :class="{'cursor-not-allowed' : item.DBInstanceStatus !== 'stopped',
                                     'hover:bg-green  hover:text-green-800 text-green-600' : item.DBInstanceStatus === 'stopped'}"
                                        :disabled="item.DBInstanceStatus !== 'stopped'"
                                        @click="changeStatus('start',item)"
                                        class="text-gray-500  bg-grey-light  py-2 px-4 rounded inline-flex items-center"
                                    >
                                        <RefreshIcon/>
                                    </button>

                                    <button
                                        :class="{'cursor-not-allowed' : item.DBInstanceStatus !== 'available',
                                                 'hover:bg-red hover:text-red-800 text-red-600' : item.DBInstanceStatus === 'available'}"
                                        :disabled="item.DBInstanceStatus !== 'available'"
                                        @click="changeStatus('stop',item)"
                                        class=" bg-grey-light text-gray-500  py-2 px-4 rounded inline-flex items-center"
                                    >
                                        <StopIcon/>
                                    </button>

                                </div>
                            </template>

                        </Td>
                    </template>
                </Tr>

            </template>
        </Table>
    </div>
</template>

<script setup>

import {onMounted, ref} from 'vue'
import Table from "../../components/Table/Table"
import Tr from "../../components/Table/Tr"
import Td from "../../components/Table/Td"
import {CheckIcon, RefreshIcon, StopIcon} from "../../components/Icons";
import RegionDropDown from "./filters/RegionDropDown"
import useRDS from '../../composables/rds'


const {index, instances, pagination, changeStatus,loading} = useRDS()
const  selectedRegionValue = ref("")

const tableHeaders = ['#', 'DB identifier', 'Status', 'Region', 'Engine', 'Size', 'Actions']


onMounted(async () => {
    await index()
})

const regionSelected = async (selectedRegion) => {
    selectedRegionValue.value = selectedRegion
    await index(selectedRegionValue.value)
}


</script>

<style scoped>

</style>
