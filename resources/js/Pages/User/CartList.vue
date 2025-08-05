<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { router, usePage } from "@inertiajs/vue3";
import { computed, reactive } from "vue";

const form = reactive({
    address1: null,
    state: null,
    zipcode: null,
    cuntry_code: null,
    type: null,
    city: null

})
const formfilde=computed( ()=>{
    return (
        form.address1 !=null &&
        form.city !=null &&
        form.zipcode !=null &&
        form.cuntry_code !=null &&
        form.state !=null &&
        form.type !=null



    )
});
const products = computed(() => usePage().props.cart.data.products);
const total = computed(() => usePage().props.cart.data.total);
const carts = computed(() => usePage().props.cart.data.items);
const itemId = (id) => carts.value.findIndex((item) => item.product_id == id);
const update = (product, quantity) => {
    router.patch(route('cart.update', product), { quantity });
}
const remove = (product) => {
    router.delete(route('cart.delete', product));

}
//function to check out
const submit=()=>{
    router.visit(route('check.store'),{
        method:'post',
        data:{
            carts:usePage().props.cart.data.items,
            products:usePage().props.cart.data.products,
            total:usePage().props.cart.data.total,
            address:form
        }
    })

}

defineProps({
    Cartitems:Object,
    userAddress:Object

})

</script>
<template>
    <UserLayout>
        <section
            class="text-gray-600 body-font relative max-w-screen-xl flex flex-wrap items-center justify-between mx-auto pb-10">
            <div class="container px-5 py-10 flex  flex-wrap">
                <div class="lg:w-2/3 md:w-1/2  h-auto rounded-[10px]   flex  relative">
                    <div class="py-4 ">
                        <table
                            class="w-full h-auto px-3 py-3 pb-3 border border-red-500 border-collapse border-b  text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-16 py-3">
                                        <span class="">Image</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Product
                                    </th>
                                    <th scope="col" class="px-6 py-3">Qty</th>
                                    <th scope="col" class="px-6 py-3">Price</th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="py-2 mr-1">
                                <tr v-for="product in products" :key="product.id"
                                    class="bg-white  border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="p-4">
                                        <img v-if="
                                            product.product_images.length >
                                            0
                                        " :src="`/storage/${product.product_images[0].image}`"
                                            class="w-16 md:w-32 max-w-full max-h-full" alt="Apple Watch" />
                                        <img v-else
                                            src="/storage/images/product_images/0c582102-24a0-410f-8209-856037bf8d9c.png"
                                            alt="user photo" class="w-16 md:w-32 max-w-full max-h-full" />
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        {{ product.title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <button @click.prevent="
                                                update(
                                                    product,
                                                    carts[
                                                        itemId(product.id)
                                                    ].quantity - 1
                                                )
                                                " :disabled="carts[itemId(product.id)]
                                                        .quantity <= 0
                                                    " :class="[
                                                    carts[itemId(product.id)]
                                                        .quantity > 1
                                                        ? `cursor-pointer text-purple-700`
                                                        : 'cursor-not-allow text-gray-500',
                                                    ` inline-flex items-center justify-center p-1 me-3 text-sm
                                                font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300
                                                rounded-full focus:outline-none hover:bg-gray-100
                                                 focus:ring-4 focus:ring-gray-200
                                                dark:bg-gray-800 dark:text-gray-400
                                                 dark:border-gray-600 dark:hover:bg-gray-700
                                                 dark:hover:border-gray-600 dark:focus:ring-gray-700`,
                                                ]" type="button">
                                                <span class="sr-only">Quantity button</span>
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                </svg>
                                            </button>
                                            <div>
                                                <input type="number" id="first_product" v-model="carts[
                                                        itemId(product.id)
                                                    ].quantity
                                                    "
                                                    class="bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    placeholder="1" value="`{{ carts.quantity }}`" required />
                                            </div>
                                            <button @click.prevent="
                                                update(
                                                    product,
                                                    carts[
                                                        itemId(product.id)
                                                    ].quantity + 1
                                                )
                                                "
                                                class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                                type="button">
                                                <span class="sr-only">Quantity button</span>
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                        ${{ product.price }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a @click="remove(product)" href="#"
                                            class="font-medium text-red-600 dark:text-red-500 hover:underline">Remove</a>
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                    </div>
                </div>
                <div
                    class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0 border border-red-500 p-2 rounded-[5px] bold">
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">
                        summry
                    </h2>
                    <p class="leading-relaxed mb-5 text-gray-600">
                        total:{{ total }}
                    </p>
                    <div v-if="userAddress">
                        <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">
                        shoping addres
                    </h2>
                    <p class="leading-relaxed mb-5 text-gray-600">
                       {{ userAddress.address1 }} _{{ userAddress.city }}_{{ userAddress.zipcode }}
                    </p>
                    </div>
                    <p v-else class="leading-relaxed mb-5 text-gray-600">
                        Add shiping address
                    </p>
                    <form @submit.prevent="submit">
                        <div class="relative mb-4">
                            <label for="address" class="leading-7 text-sm text-gray-600">Addres</label>
                            <input type="text" id="address" v-model="form.address1" name="address"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                            <label for="City" class="leading-7 text-sm text-gray-600">City</label>
                            <input type="text" id="City" v-model="form.city" name="City"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                            <label for="state" class="leading-7 text-sm text-gray-600">state</label>
                            <input type="text" id="state" v-model="form.state" name="state"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                            <label for="Zipcode" class="leading-7 text-sm text-gray-600">Zipcode</label>
                            <input type="text" id="Zipcode" v-model="form.zipcode" name="Zipcode"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                            <label for="country" class="leading-7 text-sm text-gray-600">country cod</label>
                            <input type="text" id="country" v-model="form.cuntry_code" name="country_cod"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                            <label for="Addres_type" class="leading-7 text-sm text-gray-600">Addres type</label>
                            <input type="text" v-model="form.type" id="Addres_type" name="type"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" />
                        </div>
                        <button v-if="formfilde || userAddress"  type="submit"
                            class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                            checkout
                        </button>
                         <button v-else type="submit"
                            class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                            Add shiping address
                        </button>


                    </form>



                    <p class="text-xs text-gray-500 mt-3">continu shoping</p>
                </div>
            </div>

        </section>
    </UserLayout>
</template>
