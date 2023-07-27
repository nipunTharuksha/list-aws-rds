<template>
    <div>
        <Tab ref="tab" :tabs="tabs" @tabClicked="(clickedTabIndex) => selectedTabIndex = clickedTabIndex">
            <template #tab-content>
                <keep-alive>
                    <component
                        :key="selectedTab"
                        :is="selectedTab">
                    </component>
                </keep-alive>
            </template>
        </Tab>
    </div>

</template>

<script setup>
import Tab from '../../components/Tabs/Tab'
import Logs from './tabs/Logs'
import {ref,computed} from "vue";

const tabs = ref([
    {title: 'Logs', component: "Logs"}

])

const selectedTabIndex = ref(0)

const selectedTab = computed(() => {
    let selected = null
    switch (tabs.value[selectedTabIndex.value].component) {
        case "Logs":
            selected = Logs
            break;
        case "TaxesAndDebits":
            selected = Taxes
            break;

    }

    return selected;
})
</script>

<style scoped>

</style>
