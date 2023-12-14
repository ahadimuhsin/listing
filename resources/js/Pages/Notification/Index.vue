<template>
    <h1 class="text-3xl mb-4">
        Your notifications
    </h1>
    <section v-if="notifications.data.length"
    class="text-gray-900 dark:text-gray-700">
        <div v-for="notification in notifications.data"
        :key="notification.id"
        class="border-b border-gray-200 dark:border-gray-700 py-4 flex
        justify-between items-center">
            <div>
                <span v-if="notification.type === 'App\\Notifications\\OfferMade'" class="text-md text-white">
                    Offer <Price :price="notification.data.amount"></Price> for
                    <Link class="text-indigo-600 dark:text-indigo-300" :href="route('realtor.listing.show', {listing: notification.data.listing_id})">
                    listing </Link> was made!
                </span>

                <span v-if="notification.type === 'App\\Notifications\\OfferAccepted'" class="text-md text-white">
                    Your Offer for {{ notification.data.address }} with price <Price :price="notification.data.amount"></Price> was accepted!
                </span>
            </div>
            <div>
                <Link
                v-if="!notification.read_at"
                :href="route('notification.seen', { notification: notification.id })"
                as="button"
                method="put"
                class="btn-outline text-xs font-medium uppercase"
            >Mark as read</Link>
            <span v-else class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Read</span>
            </div>
        </div>
    </section>

    <EmptyState v-else>No Notifications</EmptyState>

    <!-- pagination -->
    <section v-if="notifications.data.length" class="w-full flex justify-center my-8">
        <Pagination :links="notifications.links"></Pagination>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Price from '../../Components/Price.vue';
import EmptyState from '../../Components/UI/EmptyState.vue';
import Pagination from '../../Components/UI/Pagination.vue'

defineProps({
    notifications: Object
})
</script>
