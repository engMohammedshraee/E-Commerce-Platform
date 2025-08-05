
<template>
    <div>
    <AdminLayout class="antialiased bg-gray-50 dark:bg-gray-900" :user="user">
        <SessionMassage :status="status"></SessionMassage>
        <ProductsList
            :Products="Products"
            :brands="brands"
            :categories="categories"
        ></ProductsList>
    </AdminLayout>
    </div>

</template>
<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import ProductsList from "./ProductsList.vue";
import SessionMassage from "@/Components/SessionMassage.vue";
defineProps({
    user: Object,
    Products: Object,
    categories: Object,
    brands: Object,
    status : String
});
</script>
