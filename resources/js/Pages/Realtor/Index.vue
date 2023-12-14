<template>
  <h1 class="text-3xl mb-4">Your Listing</h1>

  <section>
    <RealtorFilters :filters="filters"></RealtorFilters>
  </section>

  <section v-if="listings.data.length" class="grid grid-cols-1 lg:grid-cols-2 gap-2">
    <Box
      v-for="listing in listings.data"
      :key="listing.id"
      :class="{ 'border-dashed': listing.deleted_at }"
    >
      <div
        class="flex flex-col md:flex-row gap-2 md:items-center justify-between"
      >
        <div :class="{ 'opacity-25': listing.deleted_at }">
            <div v-if="listing.sold_at" class="text-xs font-bold uppercase text-green-500
            border-dashed p-1 border-green-300 dark:border-green-600
            dark:text-green-600 inline-block rounded-md mb-2">Sold</div>
          <div class="xl:flex items-center gap-2">
            <Price :price="listing.price" class="text-2xl font-medium"></Price>
            <ListingSpace :listing="listing"></ListingSpace>
          </div>
          <ListingAddress
            :listing="listing"
            class="text-gray-500"
          ></ListingAddress>
        </div>
        <section>
          <div class="flex items-center gap-1 text-gray-600 dark:text-gray-300">
            <a
              class="btn-outline text-xs font-medium"
              :href="route('listing.show', { listing: listing.id })"
              target="_blank"
              >Preview</a
            >
            <Link
              class="btn-outline text-xs font-medium"
              :href="route('realtor.listing.edit', { listing: listing.id })"
              >Edit</Link
            >

            <Link
              v-if="!listing.deleted_at"
              class="btn-outline text-xs font-medium"
              :href="route('realtor.listing.destroy', listing.id)"
              as="button"
              method="delete"
              >Delete</Link
            >
            <Link
              v-else
              class="btn-outline text-xs font-medium"
              :href="route('realtor.listing.restore', listing.id)"
              as="button"
              method="put"
              >Restore</Link
            >
          </div>

          <div class="mt-2">
            <Link
            :href="route('realtor.listing.image.create', listing.id)"
        class="block w-full btn-outline text-xs font-medium text-center">Image ({{ listing.images_count }})</Link>
          </div>

          <div class="mt-2">
            <Link
            :href="route('realtor.listing.show', listing.id)"
        class="block w-full btn-outline text-xs font-medium text-center">Offers ({{ listing.offers_count }})</Link>
          </div>
        </section>
      </div>
    </Box>
  </section>

  <EmptyState v-else>No Listings Yet</EmptyState>

  <section v-if="listings.data.length" class="w-full flex justify-center mt-4 mb-4">
    <Pagination :links="listings.links"></Pagination>
  </section>
  <div class="my-4">
    Show {{ listings.data.length }} of {{ listings.total }} data
  </div>
</template>


<script setup>
import Price from "@/Components/Price.vue";
import Box from "@/Components/UI/Box.vue";
import ListingAddress from "@/Components/ListingAddress.vue";
import ListingSpace from "@/Components/ListingSpace.vue";
import { Link } from "@inertiajs/vue3";
import RealtorFilters from "../Realtor/Index/Components/RealtorFilters.vue";
import Pagination from "../../Components/UI/Pagination.vue";
import EmptyState from "../../Components/UI/EmptyState.vue";
defineProps({ listings: Object, filters: Object });
</script>
