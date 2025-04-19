<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

defineProps({
    pessoa: {
        type: Object,
        required: true
    }
});

</script>

<template>
    <AppLayout>
        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">{{ pessoa.nome }}</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink" style="">
                                <div class="dropdown-header">Opções:</div>
                                <Link :href="route('pessoas.edit', pessoa.id)" class="dropdown-item mr-2">
                                Editar
                                </Link>
                                <Link :href="route('pessoas.destroy', pessoa.id)" method="delete" as="button"
                                    class="dropdown-item" type="button">
                                Deletar
                                </Link>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2">
                                <img class="img-profile rounded-circle" src="/startbootstrap/img/undraw_profile.svg">
                            </div>
                            <div class="col-lg-10 my-auto">
                                <h6 class="m-0 font-weight-bold text-primary">{{ pessoa.nome }}</h6>
                                <p class="mb-0">{{ pessoa.telefone }}</p>
                                <p class="mb-0">Quantidade de casas: {{ pessoa.casas_count }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-center">
                            <Link :href="route('pessoas.destroy', pessoa.id)" method="delete" as="button"
                                class="btn btn-danger btn-circle mr-2" type="button">
                            <i class="fas fa-trash"></i>
                            </Link>

                            <Link :href="route('pessoas.edit', pessoa.id)" class="btn btn-primary btn-circle mr-2">
                            <i class="fas fa-pen"></i>
                            </Link>

                            <Link :href="route('casas.create.pessoa', pessoa.id)"
                                class="btn btn-primary btn-circle mr-2">
                            <i class="fas fa-home"></i>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 mx-auto">
                <div class="card shadow mb-4" v-for="casa in pessoa.casas" :key="casa.id">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">{{ casa.endereco }}</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink" style="">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <Link :href="route('casas.edit', casa.id)" class="dropdown-item mr-2">
                                Editar
                                </Link>
                                <Link :href="route('casas.destroy', casa.id)" method="delete" as="button"
                                    class="dropdown-item" type="button">
                                Deletar
                                </Link>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        
                        <div class="mt-4 text-center small">
                            <span class="mr-2">
                                <i class="fas fa-circle text-primary"></i> Direct
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-success"></i> Social
                            </span>
                            <span class="mr-2">
                                <i class="fas fa-circle text-info"></i> Referral
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
