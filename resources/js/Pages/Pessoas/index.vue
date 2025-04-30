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
            <Link :href="route('pessoas.create')" class="btn btn-primary btn-icon-split">
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
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="pessoa in pessoas" :key="pessoa.id" :class="!pessoa.casas.length?'table-warning animate__animated animate__pulse animate__infinite':''">
                        <td>
                            <div class="d-flex align-items-center">
                                <img
                                    v-if="pessoa.photos && pessoa.photos.length > 0"
                                    :src="pessoa.photos[0].url"
                                    :alt="pessoa.nome"
                                    class="img-profile rounded-circle mr-2"
                                    style="width: 32px; height: 32px; object-fit: cover;"
                                    loading="lazy"
                                >
                                <img
                                    v-else
                                    src="/startbootstrap/img/undraw_profile.svg"
                                    :alt="pessoa.nome"
                                    class="img-profile rounded-circle mr-2"
                                    style="width: 32px; height: 32px; object-fit: cover;"
                                    loading="lazy"
                                >
                                {{ pessoa.nome }}
                            </div>
                        </td>
                        <td>{{ pessoa.telefone }}</td>
                        <td>
                            <Link :href="route('pessoas.edit', pessoa.id)" class="btn btn-primary btn-circle mr-2">
                                <i class="fas fa-pen"></i>
                            </Link>
                            <Link :href="route('pessoas.destroy', pessoa.id)" method="delete" as="button"
                                class="btn btn-danger btn-circle" type="button">
                                <i class="fas fa-trash"></i>
                            </Link>
                            <Link :href="route('pessoas.show', pessoa.id)" class="btn btn-warning btn-circle m-2">
                                <i class="fas fa-eye"></i>
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
