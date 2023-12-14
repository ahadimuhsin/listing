<template>
    <Filters :filters="filters"></Filters>
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
    <Listing v-for="listing in listings.data" :key="listing.id" :listing="listing">
    </Listing>
  </div>
  <div v-if="listings.data.length" class="w-full flex justify-center my-4">
    <Pagination :links="listings.links" :info="listings"></Pagination>
  </div>
</template>

<script setup>

import Pagination from "../../Components/UI/Pagination.vue";
import Listing from "./Index/Components/Listing.vue";
import Filters from "./Index/Components/Filters.vue"
defineProps({
  listings: Object,
  filters: Object
});
</script>
