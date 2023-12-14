<template>
  <Box>
    <template #header> Make an Offer </template>
    <div>
      <form @submit.prevent="makeOffer">
        <!-- <input type="text" v-model.number="form.amount" class="input" /> -->
        <vue-number
          v-model.number="form.amount"
          class="input"
          v-bind="conf.number"
        ></vue-number>
        <input
          v-model.number="form.amount"
          type="range"
          :min="minimum"
          :max="maximum"
          step="10000"
          class="mt-2 w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
        />

        <button type="submit" class="btn-outline w-full mt-2 text-sm">
          Make an Offer
        </button>

        {{ form.errors.amount }}
      </form>
    </div>
    <div class="flex justify-between text-gray-500 mt-2">
      <div>Difference</div>
      <div>
        <Price :price="difference"></Price>
      </div>
    </div>
  </Box>
</template>

<script setup>
import Box from "../../../../Components/UI/Box.vue";
import Price from "../../../../Components/Price.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, reactive, watch } from "vue";
import { debounce } from "lodash";
import { component as VueNumber } from '@coders-tm/vue-number-format'

const conf = reactive({
  number: {
    decimal: ".",
    separator: ".",
    prefix: "",
    suffix: "",
    precision: 0,
    nullValue: "",
    masked: false,
    reverseFill: true,
  },
});

const props = defineProps({
  listingId: String,
  price: Number,
});

const form = useForm({
  amount: props.price,
});

const makeOffer = () =>
  form.post(route("listing.offer.store", { listing: props.listingId }), {
    preserveScroll: true,
    preserveState: true,
  });

const difference = computed(() => form.amount - props.price);
const minimum = computed(() => Math.round(props.price / 2));
const maximum = computed(() => Math.round(props.price * 2));

// emit event
//mengirim value dari child ke parent
const emit = defineEmits(["offerUpdated"]);

watch(
  () => form.amount, //data yg dikirim
  debounce((value) => emit("offerUpdated", value), 2000)
);
</script>
