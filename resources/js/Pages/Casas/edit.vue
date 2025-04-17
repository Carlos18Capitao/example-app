<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    pessoa: {
        type: Object,
        required: true
    }
});

const form = useForm({
    nome: props.pessoa.nome,
    telefone: props.pessoa.telefone,
    email: props.pessoa.email,
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
                                <h1 class="h4 text-gray-900 mb-4">Nova Pessoa!</h1>
                            </div>
                            <form @submit.prevent="form.patch(route('pessoas.update', pessoa.id))" class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" v-model="form.nome" id="nomeCompleto"
                                            placeholder="Nome Completo">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" v-model="form.telefone" id="telefone"
                                            placeholder="Telefone">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" v-model="form.email" id="email"
                                        placeholder="Email">
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Register Account
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


