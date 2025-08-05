<script setup>
defineProps({
    status:String
})
</script>
<template>
    <div v-if="status" class="mb-4 font-medium text-green-500 text-sm">
        <p>{{ status }}</p>
    </div>
</template>
