<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { ref, watch } from "vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import ProductsList from "@/Components/Products.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
defineProps({
    Products: Object,
    categories: Object,
    brands: Object,
});
import {
    ChevronDownIcon,
    FunnelIcon,
    MinusIcon,
    PlusIcon,
    Squares2X2Icon,
} from "@heroicons/vue/24/outline";
import {
    Dialog,
    DialogPanel,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { useForm, router } from "@inertiajs/vue3";
import { data } from "autoprefixer";

const sortOptions = [
    { name: "Most Popular", href: "#", current: true },
    { name: "Best Rating", href: "#", current: false },
    { name: "Newest", href: "#", current: false },
    { name: "Price: Low to High", href: "#", current: false },
    { name: "Price: High to Low", href: "#", current: false },
];

const filterprices = useForm({
    prices: [0, 1000],
});
const pricefilter = () => {
    filterprices
        .transform((data) => ({
            ...data,
            prices: {
                from: filterprices.prices[0],
                to: filterprices.prices[1],
            },
        }))
        .get(route("product.index"), {
            preserveState: true,
            replaceState: true,
        });
};
const selectedbrands = ref([]);
const selectedCategories = ref([]);
watch(selectedbrands, () => {
    updateproductfilter();
});
watch(selectedCategories, () => {
    updateproductfilter();
});

function updateproductfilter() {
    router.get(
        '/product/LIST',
        {
            categories: selectedCategories.value,
            brands: selectedbrands.value,
        },
        {
            preserveState: true,
            replaceState: true,
        }
    );
}

const filters = [
    {
        id: "color",
        name: "Color",
        options: [
            { value: "white", label: "White", checked: false },
            { value: "beige", label: "Beige", checked: false },
            { value: "blue", label: "Blue", checked: true },
            { value: "brown", label: "Brown", checked: false },
            { value: "green", label: "Green", checked: false },
            { value: "purple", label: "Purple", checked: false },
        ],
    },
    {
        id: "category",
        name: "Category",
        options: [
            { value: "new-arrivals", label: "New Arrivals", checked: false },
            { value: "sale", label: "Sale", checked: false },
            { value: "travel", label: "Travel", checked: true },
            { value: "organization", label: "Organization", checked: false },
            { value: "accessories", label: "Accessories", checked: false },
        ],
    },
    {
        id: "size",
        name: "Size",
        options: [
            { value: "2l", label: "2L", checked: false },
            { value: "6l", label: "6L", checked: false },
            { value: "12l", label: "12L", checked: false },
            { value: "18l", label: "18L", checked: false },
            { value: "20l", label: "20L", checked: false },
            { value: "40l", label: "40L", checked: true },
        ],
    },
];

const mobileFiltersOpen = ref(false);
</script>

<template>
    <UserLayout>
        <div class="bg-white">
            <div>
                <!-- Mobile filter dialog -->
                <TransitionRoot as="template" :show="mobileFiltersOpen">
                    <Dialog
                        as="div"
                        class="relative z-40 lg:hidden"
                        @close="mobileFiltersOpen = false"
                    >
                        <TransitionChild
                            as="template"
                            enter="transition-opacity ease-linear duration-300"
                            enter-from="opacity-0"
                            enter-to="opacity-100"
                            leave="transition-opacity ease-linear duration-300"
                            leave-from="opacity-100"
                            leave-to="opacity-0"
                        >
                            <div class="fixed inset-0 bg-black bg-opacity-25" />
                        </TransitionChild>

                        <div class="fixed inset-0 z-40 flex">
                            <TransitionChild
                                as="template"
                                enter="transition ease-in-out duration-300 transform"
                                enter-from="translate-x-full"
                                enter-to="translate-x-0"
                                leave="transition ease-in-out duration-300 transform"
                                leave-from="translate-x-0"
                                leave-to="translate-x-full"
                            >
                                <DialogPanel
                                    class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl"
                                >
                                    <div
                                        class="flex items-center justify-between px-4"
                                    >
                                        <h2
                                            class="text-lg font-medium text-gray-900"
                                        >
                                            Filters
                                        </h2>
                                        <button
                                            type="button"
                                            class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400"
                                            @click="mobileFiltersOpen = false"
                                        >
                                            <span class="sr-only"
                                                >Close menu</span
                                            >
                                            <XMarkIcon
                                                class="h-6 w-6"
                                                aria-hidden="true"
                                            />
                                        </button>
                                    </div>

                                    <!-- Filters -->
                                    <form class="mt-4 border-t border-gray-200">
                                        <h3 class="sr-only">Categories</h3>
                                        <ul
                                            role="list"
                                            class="px-2 py-3 font-medium text-gray-900"
                                        >
                                            <li
                                                v-for="category in subCategories"
                                                :key="category.name"
                                            >
                                                <a
                                                    :href="category.href"
                                                    class="block px-2 py-3"
                                                    >{{ category.name }}</a
                                                >
                                            </li>
                                        </ul>

                                        <Disclosure
                                            as="div"
                                            class="border-t border-gray-200 px-4 py-6"
                                            v-slot="{ open }"
                                        >
                                            <h3 class="-mx-2 -my-3 flow-root">
                                                <DisclosureButton
                                                    class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500"
                                                >
                                                    <span
                                                        class="font-medium text-gray-900"
                                                        >brands</span
                                                    >
                                                    <span
                                                        class="ml-6 flex items-center"
                                                    >
                                                        <PlusIcon
                                                            v-if="!open"
                                                            class="h-5 w-5"
                                                            aria-hidden="true"
                                                        />
                                                        <MinusIcon
                                                            v-else
                                                            class="h-5 w-5"
                                                            aria-hidden="true"
                                                        />
                                                    </span>
                                                </DisclosureButton>
                                            </h3>
                                            <DisclosurePanel class="pt-6">
                                                <div class="space-y-6">
                                                    <div
                                                        v-for="brand in brands"
                                                        :key="brand.id"
                                                        class="flex items-center"
                                                    >
                                                        <input
                                                            :id="`filter-${brand.id}`"
                                                            :value="brand.id"
                                                            type="checkbox"
                                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                        />
                                                        <label
                                                            :for="`filter-${brand.id}`"
                                                            class="ml-3 min-w-0 flex-1 text-gray-500"
                                                        >
                                                            {{ brand.name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </DisclosurePanel>
                                        </Disclosure>
                                    </form>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </Dialog>
                </TransitionRoot>

                <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div
                        class="flex items-baseline justify-between border-b border-gray-200 pt-24 pb-6"
                    >
                        <h1
                            class="text-4xl font-bold tracking-tight text-gray-900"
                        >
                            New Arrivals
                        </h1>

                        <div class="flex items-center">
                            <Menu
                                as="div"
                                class="relative inline-block text-left"
                            >
                                <div>
                                    <MenuButton
                                        class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                    >
                                        Sort
                                        <ChevronDownIcon
                                            class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                                            aria-hidden="true"
                                        />
                                    </MenuButton>
                                </div>

                                <transition
                                    enter-active-class="transition ease-out duration-100"
                                    enter-from-class="transform opacity-0 scale-95"
                                    enter-to-class="transform opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95"
                                >
                                    <MenuItems
                                        class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    >
                                        <div class="py-1">
                                            <MenuItem
                                                v-for="option in sortOptions"
                                                :key="option.name"
                                                v-slot="{ active }"
                                            >
                                                <a
                                                    :href="option.href"
                                                    :class="[
                                                        option.current
                                                            ? 'font-medium text-gray-900'
                                                            : 'text-gray-500',
                                                        active
                                                            ? 'bg-gray-100'
                                                            : '',
                                                        'block px-4 py-2 text-sm',
                                                    ]"
                                                >
                                                    {{ option.name }}
                                                </a>
                                            </MenuItem>
                                        </div>
                                    </MenuItems>
                                </transition>
                            </Menu>

                            <button
                                type="button"
                                class="-m-2 ml-5 p-2 text-gray-400 hover:text-gray-500 sm:ml-7"
                            >
                                <span class="sr-only">View grid</span>
                                <Squares2X2Icon
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                />
                            </button>
                            <button
                                type="button"
                                class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden"
                                @click="mobileFiltersOpen = true"
                            >
                                <span class="sr-only">Filters</span>
                                <FunnelIcon
                                    class="h-5 w-5"
                                    aria-hidden="true"
                                />
                            </button>
                        </div>
                    </div>

                    <section
                        aria-labelledby="products-heading"
                        class="pt-6 pb-24"
                    >
                        <h2 id="products-heading" class="sr-only">Products</h2>

                        <div
                            class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4"
                        >
                            <!-- Filters -->
                            <form class="hidden lg:block">
                                <!--filter prices-->
                                <div
                                    class="p-4 bg-white rounded-lg shadow-md mb-6"
                                >
                                    <h3>Prices</h3>

                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <!-- حقل "من" -->
                                        <div class="flex items-center gap-2">
                                            <label
                                                for="min_price"
                                                class="block mb-2 text-sm font-medium text-gray-700"
                                                >from</label
                                            >
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                                                >
                                                    <span class="text-gray-500"
                                                        >$</span
                                                    >
                                                </div>
                                                <input
                                                    type="number"
                                                    v-model="
                                                        filterprices.prices[0]
                                                    "
                                                    id="min_price"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-8 p-2.5"
                                                    min="0"
                                                />
                                            </div>
                                        </div>

                                        <!-- حقل "إلى" -->
                                        <div
                                            class="flex items-center justify-between gap-2"
                                        >
                                            <label
                                                for="max_price"
                                                class="block mb-2 text-sm font-medium text-gray-700"
                                                >to</label
                                            >
                                            <div class="relative">
                                                <div
                                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                                                >
                                                    <span class="text-gray-500"
                                                        >$</span
                                                    >
                                                </div>
                                                <input
                                                    type="number"
                                                    v-model="
                                                        filterprices.prices[1]
                                                    "
                                                    id="max_price"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-8 p-2.5"
                                                    min="0"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    <!-- أزرار الفلتر -->
                                    <SecondaryButton @click="pricefilter()">
                                        ok
                                    </SecondaryButton>
                                </div>

                                <!-- end filter prices-->

                                <!--  filter brands-->
                                <Disclosure
                                    as="div"
                                    class="border-t border-gray-200 px-4 py-6"
                                    v-slot="{ open }"
                                >
                                    <h3 class="-mx-2 -my-3 flow-root">
                                        <DisclosureButton
                                            class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500"
                                        >
                                            <span
                                                class="font-medium text-gray-900"
                                                >brands</span
                                            >
                                            <span
                                                class="ml-6 flex items-center"
                                            >
                                                <PlusIcon
                                                    v-if="!open"
                                                    class="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                                <MinusIcon
                                                    v-else
                                                    class="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                            </span>
                                        </DisclosureButton>
                                    </h3>
                                    <DisclosurePanel class="pt-6">
                                        <div class="space-y-6">
                                            <div
                                                v-for="brand in brands"
                                                :key="brand.id"
                                                class="flex items-center"
                                            >
                                                <input
                                                    :id="`filter-${brand.id}`"
                                                    v-model="selectedbrands"
                                                    :value="brand.id"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                />
                                                <label
                                                    :for="`filter-${brand.id}`"
                                                    class="ml-3 min-w-0 flex-1 text-gray-500"
                                                >
                                                    {{ brand.name }}
                                                </label>
                                            </div>
                                        </div>
                                    </DisclosurePanel>
                                </Disclosure>
                                <!-- end filter brands-->
                                <!--  filter categories-->
                                <Disclosure
                                    as="div"
                                    class="border-t border-gray-200 px-4 py-6"
                                    v-slot="{ open }"
                                >
                                    <h3 class="-mx-2 -my-3 flow-root">
                                        <DisclosureButton
                                            class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500"
                                        >
                                            <span
                                                class="font-medium text-gray-900"
                                                >categories</span
                                            >
                                            <span
                                                class="ml-6 flex items-center"
                                            >
                                                <PlusIcon
                                                    v-if="!open"
                                                    class="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                                <MinusIcon
                                                    v-else
                                                    class="h-5 w-5"
                                                    aria-hidden="true"
                                                />
                                            </span>
                                        </DisclosureButton>
                                    </h3>
                                    <DisclosurePanel class="pt-6">
                                        <div class="space-y-6">
                                            <div
                                                v-for="category in categories"
                                                :key="category.id"
                                                class="flex items-center"
                                            >
                                                <input
                                                    :id="`filter-${category.id}`"
                                                    :value="category.id"
                                                    v-model="selectedCategories"
                                                    type="checkbox"
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                                />
                                                <label
                                                    :for="`filter-${category.id}`"
                                                    class="ml-3 min-w-0 flex-1 text-gray-500"
                                                >
                                                    {{ category.name }}
                                                </label>
                                            </div>
                                        </div>
                                    </DisclosurePanel>
                                </Disclosure>
                                <!-- end filter brands-->
                            </form>

                            <!-- Product grid -->
                            <div class="lg:col-span-3">
                                <!-- Your product grid content goes here -->
                                <div class="bg-gray-100 p-8 rounded-lg">
                                    <ProductsList
                                        :Products="Products.data"
                                    ></ProductsList>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </UserLayout>
</template>
