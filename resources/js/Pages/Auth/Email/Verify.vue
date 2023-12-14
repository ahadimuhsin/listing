<template>
  <h3>You need to verified to access this page</h3>
  <p>
    Please click this
    <Link :href="route('verification.send')" class=" text-blue-600 dark:text-blue-800" method="post" as="button">link</Link>
    to resend verification email
  </p>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
</script>
