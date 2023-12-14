<template>
    <div v-if="message" class="error-message">
        {{ message }}
    </div>
</template>


<script setup>
defineProps({
    message: String
});
</script>
