<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const pessoas = ref([]);

onMounted(() => {
    axios.get('/api/pessoas').then((response) => {
        pessoas.value = response.data;
    });
});
</script>

<template>
    <AppLayout>
        <div>
            <h1>Pessoas</h1>
        </div>
    </AppLayout>
</template>


