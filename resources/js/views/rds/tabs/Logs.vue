<template>
    <div>
        <Table
            :table-headers="tableHeaders"
            :paginationData="pagination"
            :number-of-rows="events.length"
            :loading="loading"
            @pageChanged="(page) => pageChanged(page)"
        >

            <template #tbody>
                <Tr v-for="(item,index) in events" :key="index">
                    <template #td>
                        <Td :value="`#${item.id}`"/>

                        <Td :value="item.time"/>
                        <Td :value="item.category"/>
                        <Td :value="item.message"/>

                    </template>
                </Tr>

            </template>
        </Table>
    </div>
</template>

<script setup>

import {onMounted} from 'vue'
import Table from "../../../components/Table/Table"
import Tr from "../../../components/Table/Tr"
import Td from "../../../components/Table/Td"
import useSingleRDS from '../../../composables/singleRDS'
import {useRoute} from "vue-router";


const { getEvents, loading, events,pagination,pageChanged} = useSingleRDS()

const tableHeaders = ['#', 'Time', 'Event Category', 'Note']

const route = useRoute()

onMounted(async () => {
    await getEvents(route.params.DBInstanceIdentifier,route.params.region)
})


</script>

<style scoped>

</style>
