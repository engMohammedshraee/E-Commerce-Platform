<script setup>
// import { onMounted } from 'vue'
// import { initFlowbite } from 'flowbite'
import AdminLayout from '@/Layouts/AdminLayout.vue';
// initialize components based on data attribute selectors
// onMounted(() => {
//     initFlowbite();
// })
defineProps({
    user:Object
})
</script>


<template>
    <AdminLayout :user="user">

        <main >

        </main>
    </AdminLayout>
</template>
