<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import AppLayout from '@/Layouts/AppLayout.vue'

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <AppLayout>


    </AppLayout>
</template>
