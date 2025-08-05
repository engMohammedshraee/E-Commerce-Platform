<script setup>
import { Link, router } from "@inertiajs/vue3";

defineProps({
    Products:Object
})
const addtocart = (product) => {
    console.log(product);
    router.post(route('cart.store', product.id));
};

</script>
<template>
      <div
                        class="mt-6 grid grid-cols-3 sm:grid-cols-3 lg:grid-cols-4 gap-6"
                    >
                        <div
                            v-for="product in Products"
                            :key="product.id"
                            class="group relative"
                        >
                            <div
                                class="aspect-h-1 aspect-w-1 lg:h-80 w-full overflow-hidden rounded-md bg-gray-200"
                            >
                                <img
                                    v-if="product.product_images.length > 0"
                                    :src="`/storage/${product.product_images[0].image}`"
                                    alt="no image"
                                    class="w-full h-full object-cover object-center group-hover:opacity-75"
                                />
                                <img
                                    v-else
                                    src="data:image/png;base64,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"
                                    alt="no image"
                                    class="w-full h-full lg:h-full lg:w-full object-cover object-center group-hover:opacity-75"
                                />
                            </div>
                            <!--add to cart icon-->
                            <div
                                class="absolute inset-0 flex gap-4 text-white items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer"
                            >
                                <div class="bg-blue-700 p-1 rounded-full">
                                    <a
                                        @click="addtocart(product)"
                                        style="position: relative; z-index: 100"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="size-7"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"
                                            />
                                        </svg>
                                    </a>
                                </div>
                                <div class="bg-blue-700 rounded-full p-1">
                                    <a @click="addtocart(product)">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="size-7"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                            />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!--end add to cart icon-->

                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3
                                        class="text-sm text-gray-700 flex items-center justify-between gap-10"
                                    >
                                        <a href="#">
                                            <span
                                                aria-hidden="true"
                                                class="absolute inset-0"
                                            />
                                            {{ product.title }}
                                        </a>
                                        <span>${{ product.price }}</span>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ product.category.name }}
                                    </p>
                                    <p
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ product.brand.name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
</template>
