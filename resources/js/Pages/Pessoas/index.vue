<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    pessoas: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <AppLayout>
        <div class="container-fluid mb-3">
            <Link href="/pessoas/create" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                </span>
                <span class="text">Nova Pessoa</span>
            </Link>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>

                        <th>Nome</th>
                        <th>telefone</th>

                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="pessoa in pessoas" :key="pessoa.id">
                        <td>{{ pessoa.nome }}</td>
                        <td>{{ pessoa.telefone }}</td>
                        <td>
                            <a href="#" class="btn btn-primary mr-2">Editar</a>
                            <a href="#" class="btn btn-danger">Excluir</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
