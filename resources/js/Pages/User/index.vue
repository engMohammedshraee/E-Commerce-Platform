<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import HeroUser from "@/Components/HeroUser.vue";
import Products from "@/Components/Products.vue";
import { Link} from "@inertiajs/vue3";


const props = defineProps({
    products: Object,
});

console.log(props.totalquantity);

</script>
<template>
    <UserLayout>
        <HeroUser></HeroUser>
        <main>
            <p class="text-black font-sm">{{ totalquantity }}</p>
            <div
                v-if="$page.props.flash.success"
                class="bg-green-100 text-green-800 p-4 mb-4"
            >
                {{ $page.props.flash.success }}
            </div>

            <div class="bg-white flex">
                <div
                    class="mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8"
                >
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                        Customers also purchased{{ status }}
                    </h2>
                    <Products :Products="products"></Products>


                    <div class="flex justify-center mt-5">
                        <Link :href="route('product.index')"
                        class="flex justify-center text-white bg-gradient-to-r from-teal-400 via-teal-500 to-teal-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-teal-300 dark:focus:ring-teal-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">


                        productlist
                        </Link>


                    </div>


                </div>
            </div>
        </main>
    </UserLayout>
</template>
