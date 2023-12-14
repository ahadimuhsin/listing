<template>
  <div class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
    <Box v-if="listing.images.length" class="md:col-span-7 flex items-center">
      <div  class="grid grid-cols-2 gap-1">
        <img v-for="image in listing.images" :src="image.src" :key="image.id">
      </div>
    </Box>
    <EmptyState class="md:col-span-7 flex items-center" v-else>No Images</EmptyState>
    <div class="md:col-span-5">
      <Box>
        <template #header>
            Basic Information
        </template>
        <Price :price="listing.price" class="text-2xl font-bold"></Price>
        <ListingSpace :listing="listing" class="text-lg"></ListingSpace>
        <ListingAddress
          :listing="listing"
          class="text-gray-500"
        ></ListingAddress>
      </Box>

      <Box>
        <template #header>Monthly Payment</template>
        <div>
            <label for="label">Interest Rate({{interestRate}}%)</label>
            <input type="range" min="0.1" max="30" step="0.1"
            class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" v-model.number="interestRate">

            <label for="label">Duration({{duration}} years)</label>
            <input type="range" min="3" max="35" step="1"
            class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700" v-model.number="duration">

            <div class="text-gray dark:text-gray-300 mt-2">
                <div class="text-gray-400">Your monthly payment</div>
                <Price :price="monthlyPayment" class="text-3xl"></Price>
            </div>

            <div class="mt-2 text-gray-500">
                <div class="flex justify-between">
                    <div>Total Paid</div>
                    <div>
                        <Price :price="totalPaid" class="font-medium"/>
                    </div>
                </div>

                <div class="flex justify-between">
                    <div>Principal Paid</div>
                    <div>
                        <Price :price="listing.price" class="font-medium"/>
                    </div>
                </div>

                <div class="flex justify-between">
                    <div>Total Interest</div>
                    <div>
                        <Price :price="totalInterest" class="font-medium"/>
                    </div>
                </div>
            </div>
        </div>
      </Box>

      <make-offer
      v-if="user && !offerMade"
      :listing-id="listing.id"
      :price="listing.price"
      @offer-updated="offer = $event"></make-offer>

      <OfferMade v-if="user && offerMade" :offer="offerMade"></OfferMade>
    </div>
  </div>
</template>


<script setup>
import Box from "@/Components/UI/Box.vue";
import ListingAddress from "@/Components/ListingAddress.vue";
import ListingSpace from "@/Components/ListingSpace.vue";
import Price from "@/Components/Price.vue";
import { useMonthlyPayment } from "../../Composables/useMonthlyPayment";
import { computed, ref } from "vue";
import MakeOffer from "./Show/Components/MakeOffer.vue";
import { usePage } from "@inertiajs/vue3";
import OfferMade from "./Show/Components/OfferMade.vue";
import EmptyState from "../../Components/UI/EmptyState.vue";


const props = defineProps({
  listing: Object,
  offerMade: Object
});

const offer = ref(props.listing.price);

const interestRate = ref(2.5);
const duration = ref(25);

const {monthlyPayment, totalPaid, totalInterest} = useMonthlyPayment(offer, interestRate, duration)
const page = usePage();
const user = computed(() => page.props.user);
</script>
