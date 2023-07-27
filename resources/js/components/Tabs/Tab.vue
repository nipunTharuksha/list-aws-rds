<template>
    <div class="flex flex-wrap">
        <div class="w-full">
            <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                <li v-for="(tab,index) in tabs" :key="index" class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a class="text-sm font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal tab-item"
                       v-on:click="toggleTabs(index)"
                       v-bind:class="{'text-indigo-600 bg-white': openTab !== index, 'text-white bg-indigo-600': openTab === index}">
                        <component
                            :id="index"
                            :key="index"
                            :is="tab.component">
                        </component>
                        <span class="pl-2">{{
                            tab.title
                            }} </span>
                    </a>
                </li>
            </ul>

            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="px-4 py-5 flex-auto">
                    <div class="tab-content tab-space">
                        <slot name="tab-content">
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import {ref} from "vue";

const props = defineProps({tabs: {required: true, type: Array}})
const emits = defineEmits(['tabClicked'])

const openTab = ref(0)

function toggleTabs(tabIndex) {
    openTab.value = tabIndex
    emits('tabClicked', tabIndex)
}
defineExpose({toggleTabs})

</script>
<style>
.tab-item{
    width: 100px;
}
</style>

