<template>
  <form @submit.prevent="create">
    <div class="grid grid-cols-6 gap-3">
      <div class="col-span-2">
        <label class="label">Beds</label>
        <input
          v-model.number="form.beds"
          type="number"
          class="input"
          max="20"
        />
        <ErrorMessage :message="form.errors.beds"></ErrorMessage>
      </div>

      <div class="col-span-2">
        <label class="label">Baths</label>
        <input
          v-model.number="form.baths"
          type="number"
          class="input"
          max="5"
        />
        <ErrorMessage :message="form.errors.baths"></ErrorMessage>
      </div>

      <div class="col-span-2">
        <label class="label">Area</label>
        <input
          v-model.number="form.area"
          type="number"
          class="input"
          max="2000"
        />
        <ErrorMessage :message="form.errors.area"></ErrorMessage>
      </div>

      <div class="col-span-4">
        <label class="label">City</label>
        <input
          v-model="form.city"
          type="text"
          class="input"
          placeholder="Nama Kota"
        />
        <ErrorMessage :message="form.errors.city"></ErrorMessage>
      </div>

      <div class="col-span-2">
        <label class="label">Post Code</label>
        <input
          v-model="form.code"
          type="text"
          class="input"
          placeholder="Kode Pos"
        />
        <ErrorMessage :message="form.errors.code"></ErrorMessage>
      </div>

      <div class="col-span-4">
        <label class="label">Street</label>
        <input
          v-model="form.street"
          type="text"
          class="input"
          placeholder="Nama Jalan"
        />
        <ErrorMessage :message="form.errors.street"></ErrorMessage>
      </div>

      <div class="col-span-2">
        <label class="label">Street Number</label>
        <input
          v-model="form.street_number"
          type="text"
          class="input"
          placeholder="Nomor Rumah"
        />
        <ErrorMessage :message="form.errors.street_number"></ErrorMessage>
      </div>

      <div class="col-span-6">
        <label class="label">Price</label>
        <!-- <input v-model.number="form.price" type="number" class="input" max="20000000000"/> -->
        <vue-number
          v-model.number="form.price"
          class="input"
          v-bind="conf.number"
        ></vue-number>
        <ErrorMessage :message="form.errors.price"></ErrorMessage>
      </div>

      <div class="col-span-2">
        <button type="submit" class="btn-primary">Create</button>
      </div>
    </div>
  </form>
</template>

<script setup>
import ErrorMessage from "../../Components/UI/ErrorMessage.vue";
import { useForm } from "@inertiajs/vue3";
import { reactive } from "vue";
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
const form = useForm({
  beds: 0,
  baths: 0,
  area: 0,
  city: null,
  street: null,
  code: null,
  street_number: null,
  price: 0,
});

const create = () => form.post(route("realtor.listing.store"));
</script>
