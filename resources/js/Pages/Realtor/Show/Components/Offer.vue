<template>
    <Box>
        <template #header>
            Offer #{{ offer.id }}
            <span v-if="offer.accepted_at" class="dark:bg-green-900
            dark:text-green-200 bg-green-400 text-green-900 rounded-md uppercase ml-2">accepted</span>
        </template>

        <section class="flex items-center justify-between">
            <div>
                <Price :price="offer.amount" class="text-xl"></Price>
                <div class="text-gray-500">
                    Difference <Price :price="difference"></Price>
                </div>

                <div class="text-gray-500 text-sm">
                    Made by <b>{{ offer.bidder.name }}</b>
                </div>

                <div class="text-gray-500 text-sm">
                    Made on {{ madeOn }}
                </div>
            </div>
            <!-- {{ !offer.accepted_at }} -->
            <div v-if="!isSold">
                <Link class="btn-outline text-xs font-medium"
                as="button" :href="route('realtor.offer.accept', {offer: offer.id})"
                method="put">Accept</Link>
            </div>
        </section>
    </Box>
</template>


<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import Box from '../../../../Components/UI/Box.vue';
import Price from "@/Components/Price.vue";
import { computed } from 'vue';
import { DateTime } from "luxon";

const props = defineProps({
    offer: Object,
    listingPrice: Number,
    isSold: Boolean
})

const difference = computed(() => {
    return props.offer.amount - props.listingPrice
})


const madeOn = computed(() => {
    return DateTime.fromISO(props.offer.created_at).toFormat("dd MMMM yyyy HH:mm:ss")
});
</script>
