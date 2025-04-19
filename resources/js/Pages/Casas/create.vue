<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';


const props = defineProps({
    pessoa: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    endereco: '',
    bairro: '',
    cidade: '',
    provincia: '',
    numero: '',
    pessoa_id: props.pessoa.id,
});

</script>

<template>
    <AppLayout>

        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->

                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Casa de {{ props.pessoa.nome }}</h1>
                            </div>
                            <form @submit.prevent="form.post(route('casas.store'))" class="user">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" v-model="form.endereco" id="endereco"
                                        placeholder="Endereço">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" v-model="form.provincia" id="provincia"
                                            placeholder="Provincia">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" v-model="form.cidade" id="cidade"
                                            placeholder="Cidade">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" v-model="form.bairro" id="bairro"
                                            placeholder="Bairro">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" v-model="form.numero" id="numero"
                                            placeholder="Nº de Casa">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Registar Casa
                                </button>
                                <hr>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
