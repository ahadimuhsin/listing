<template>
  <form @submit.prevent="update">
    <div class="grid grid-cols-6 gap-3">
      <div class="col-span-2">
        <label class="label">Beds</label>
        <input v-model.number="form.beds" type="text" class="input"/>
        <div v-if="form.errors.beds" class="error-message">
          {{ form.errors.beds }}
        </div>
      </div>

      <div class="col-span-2">
        <label class="label">Baths</label>
        <input v-model.number="form.baths" type="text" class="input"/>
        <div v-if="form.errors.baths" class="error-message">
          {{ form.errors.baths }}
        </div>
      </div>

      <div class="col-span-2">
        <label class="label">Area</label>
        <input v-model.number="form.area" type="text" class="input"/>
        <div v-if="form.errors.area" class="error-message">
          {{ form.errors.area }}
        </div>
      </div>

      <div class="col-span-4">
        <label class="label">City</label>
        <input v-model="form.city" type="text" class="input"/>
        <div v-if="form.errors.city" class="error-message">
          {{ form.errors.city }}
        </div>
      </div>

      <div class="col-span-2">
        <label class="label">Post Code</label>
        <input v-model="form.code" type="text" class="input"/>
        <div v-if="form.errors.code" class="error-message">
          {{ form.errors.code }}
        </div>
      </div>

      <div class="col-span-4">
        <label class="label">Street</label>
        <input v-model="form.street" type="text" class="input"/>
        <div v-if="form.errors.street" class="error-message">
          {{ form.errors.street }}
        </div>
      </div>

      <div class="col-span-2">
        <label class="label">Street Number</label>
        <input v-model="form.street_number" type="text" class="input"/>
        <div v-if="form.errors.street_number" class="error-message">
          {{ form.errors.street_number }}
        </div>
      </div>

      <div class="col-span-6">
        <label class="label">Price</label>
        <!-- <input v-model.number="form.price" type="text" class="input"/> -->
        <vue-number
          v-model.number="form.price"
          class="input"
          v-bind="conf.number"
        ></vue-number>
        <div v-if="form.errors.price" class="error-message">
          {{ form.errors.price }}
        </div>
      </div>

      <div class="col-span-2">
        <button type="submit" class="btn-primary">Update</button>
      </div>
    </div>
  </form>
</template>

<style scoped>
label {
  margin-right: 2em;
}
div {
  padding: 2px;
}
</style>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
import { component as VueNumber } from '@coders-tm/vue-number-format'


const props = defineProps({
    listing: Object
})

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
    prefill: true
  },
});

const form = useForm({
  beds: props.listing.beds,
  baths: props.listing.baths,
  area: props.listing.area,
  city: props.listing.city,
  street: props.listing.street,
  code: props.listing.code,
  street_number: props.listing.street_number,
  price: props.listing.price,
});

const update = () => form.put(route('realtor.listing.update', {listing: props.listing.id}));
</script>
