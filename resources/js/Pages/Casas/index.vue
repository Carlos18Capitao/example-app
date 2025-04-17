<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    casas: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <AppLayout>
        
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>

                        <th>Endereço</th>
                        <th>Dono</th>

                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="casa in casas" :key="casa.id">
                        <td>{{ casa.endereco }}</td>
                        <td>{{ casa.pessoa.nome }}</td>
                        <td>
                            <Link :href="route('casas.edit', casa.id)" class="btn btn-primary btn-circle mr-2 mr-2">
                            <i class="fas fa-pen"></i>
                            </Link>
                            <Link :href="route('casas.destroy', casa.id)" method="delete" as="button"
                                class="btn btn-danger btn-circle" type="button">
                                <i class="fas fa-trash"></i>
                            </Link>
                            <Link :href="route('casas.show', casa.id)" class="btn btn-warning btn-circle ml-2">
                            <i class="fas fa-eye"></i>
                            </Link>

                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
