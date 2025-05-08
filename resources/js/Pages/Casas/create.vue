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
    sala: 1,
    quarto: 1,
    casaBanho: 1,
    cozinha: 1,
    pessoa_id: props.pessoa.id,
});

const rules = {
    endereco: 'required',
    sala: 'required|integer',
    quarto: 'required|integer',
    casaBanho: 'required|integer',
    cozinha: 'required|integer',
};
const messages = {
    required: 'Este campo é obrigatório.',
    integer: 'Este campo deve ser um número inteiro.',
};
const validate = () => {
    const errors = {};
    for (const field in rules) {
        const rule = rules[field];
        const value = form[field];
        if (rule.includes('required') && !value) {
            errors[field] = messages.required;
        }
        if (rule.includes('integer') && !Number.isInteger(value)) {
            errors[field] = messages.integer;
        }
    }
    return errors;
};
const submit = () => {
    const errors = validate();
    if (Object.keys(errors).length > 0) {
        // Handle validation errors
        console.log(errors);
        return;
    }
    form.post(route('casas.store'), {
        onSuccess: () => {
            form.reset();
        },
    });
};

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
                            <form @submit.prevent="submit" class="user">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" v-model="form.endereco" id="endereco"
                                        placeholder="Endereço">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                        <input type="number" class="form-control form-control-user" v-model="form.sala" id="sala">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control form-control-user" v-model="form.quarto" id="quarto">
                                    </div>
                                    <div class="col-sm-3 mb-3 mb-sm-0">
                                        <input type="number" class="form-control form-control-user" v-model="form.casaBanho" id="casaBanho">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control form-control-user" v-model="form.cozinha" id="cozinha" >
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
