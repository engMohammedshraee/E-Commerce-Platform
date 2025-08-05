<script setup>
defineProps({
    paginator: Object,
});
const makelabel = (label) => {
    if (label.includes("Previous")) {
        return "<<";
    } else if (label.includes("Next")) {
        return ">>";
    } else {
        return label;
    }
};
</script>
<template>
    <div class="flex justify-between items-center">
        <div class="flex rounded-lg items-center overflow-hidden shadow-lg justify-between">
            <div v-for="(link, i) in paginator.links" :key="i" >
                <component
                    :is="link.url ? 'Link' : 'span'"
                    :href="link.url"
                    :preserve-scroll="true"
                    v-html="makelabel(link.label)"
                    class="border-x border-slate-50 h-12 w-12 grid place-items-center bg-white"
                    :class="{
                        'hover: bg-slate-300 ': link.url,
                        'text-slate-300': !link.url,
                        'font-bold text-indigo-300': link.active,
                    }"
                />
            </div>

        </div>
        <div class="flex items-center">
                show {{ paginator.from }} to {{ paginator.to }} of {{ paginator.total }}

            </div>
    </div>
</template>
