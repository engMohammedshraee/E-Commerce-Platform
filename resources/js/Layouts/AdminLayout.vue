<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import Navebare from "../../js/Components/Navebare.vue";
import Sidebare from "../../js/Components/Sidebare.vue";
// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
defineProps({
    user:Object
})
</script>
<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <Navebare :user="user"></Navebare>
        <Sidebare></Sidebare>

        <main class="p-4 md:ml-64 h-auto pt-20">
        <slot/>

        </main>
    </div>
</template>
