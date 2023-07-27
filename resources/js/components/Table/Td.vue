<template>
    <td>
        <div :class="classes" class="flex items-center pl-5 py-2">

            <slot name="content" v-if="$slots && $slots.content && $slots.content() && $slots.content().length">

            </slot>
            <div v-else>
                <p v-if="html" class="text-sm font-normal leading-none text-gray-700 mr-2" v-html="value"></p>
                <p :class="pClasses" v-else class="text-sm font-normal leading-none text-gray-700 mr-2">
                    {{ value || "N/A" }}
                </p>
            </div>
        </div>
    </td>
</template>

<script setup>
const props = defineProps({value: {type: String}, html: {type: Boolean, default: false}, classes: {default: ''},pClasses: {default: ''}})
</script>

<style scoped>

</style>
