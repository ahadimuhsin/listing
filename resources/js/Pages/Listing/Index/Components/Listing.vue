<template>
  <Box>
    <div>
      <Link :href="route('listing.show', listing.id)">
        <div class="flex items-center gap-3">
          <Price :price="listing.price" class="text-2xl font-bold"></Price>
          <div class="text-xs text-gray-700 dark:text-gray-400">
            <Price :price="monthlyPayment"></Price> pm
          </div>
        </div>
        <ListingSpace :listing="listing" class="text-lg"></ListingSpace>
        <ListingAddress :listing="listing" class="text-gray-500"></ListingAddress>
        <h6 class="text-gray-500">Created By: {{ listing.owner.name }}</h6>
      </Link>
    </div>
  </Box>
</template>

<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import ListingAddress from "@/Components/ListingAddress.vue";
import ListingSpace from "@/Components/ListingSpace.vue";
import Price from "@/Components/Price.vue";
import Box from "@/Components/UI/Box.vue";
import { useMonthlyPayment } from "@/Composables/useMonthlyPayment";
import { computed } from "vue";

const page = usePage();
const props = defineProps({ listing: Object });

const deleteListing = (id) => {
  router.visit(route("realtor.listing.destroy", id), {
    method: "delete",
    onBefore: () => confirm("Are you sure?"),
  });
};

const { monthlyPayment } = useMonthlyPayment(props.listing.price, 2.5, 25);
const user = computed(() => page.props.user ?? null);
</script>
