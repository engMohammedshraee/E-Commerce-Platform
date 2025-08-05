<script setup>
 import UserFooter from '@/Components/UserFooter.vue';
 import HeaderUser from '@/Components/HeaderUser.vue';
 import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})

</script>
<template>
    <div>
        <HeaderUser></HeaderUser>
        <slot/>
        <UserFooter></UserFooter>
    </div>

</template>
