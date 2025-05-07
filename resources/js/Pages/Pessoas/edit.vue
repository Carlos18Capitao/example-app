<script setup>
import { ref, watch } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const props = defineProps({
    pessoa: {
        type: Object,
        required: true
    }
});

const form = useForm({
    nome: props.pessoa.nome,
    telefone: props.pessoa.telefone,
    // url: null
    //email: props.pessoa.email,
    // url: props.pessoa.photos && props.pessoa.photos.length > 0 ? props.pessoa.photos[0].url : null, // for image file
});

const imagePreview = ref(props.pessoa.photos && props.pessoa.photos.length > 0 ? props.pessoa.photos[0].url : null);

function onFileChange(event) {
    const file = event.target.files[0];
    form.url = file;
    if (!file) {
        imagePreview.value = props.pessoa.photos && props.pessoa.photos.length > 0 ? props.pessoa.photos[0].url : null;
    }
    const reader = new FileReader();
    reader.onload = e => {
        imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
}

function submit() {
    // Remove url field if it is not a File to avoid backend validation error
    if (!(form.url instanceof File)) {
        delete form.url;
    }

    form.put(route('pessoas.update', props.pessoa.id), {
        forceFormData: true,
        onSuccess: () => alert('Pessoa atualizada com sucesso!'),
        onError: (errors) => {
            // alert('Erro ao atualizar pessoa. Verifique os dados e tente novamente.');
        },
    });
}
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
                                <h1 class="h4 text-gray-900 mb-4">Editar Pessoa!</h1>
                            </div>
                            <form @submit.prevent="submit" class="user">

                                <div class="form-group">
                                    <input type="file" name="url" id="url" class="form-control form-control-user"
                                        style="display: none;" @change="onFileChange" accept="image/*">
                                    <div v-if="form.errors.url" class="text-danger mt-1">
                                        {{ form.errors.url }}
                                    </div>
                                    <div v-if="imagePreview" class="mt-3 text-center">
                                        <label for="url" style="cursor: pointer;">
                                            <img :src="imagePreview" class="img-profile rounded-circle"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        </label>
                                    </div>
                                    <div class="mt-3 text-center" v-else>
                                        <label for="url" style="cursor: pointer;">
                                            <img style="width: 100px; height: 100px; object-fit: cover;"
                                                class="img-profile rounded-circle"
                                                src="/startbootstrap/img/undraw_profile.svg">
                                        </label>
                                    </div>
                                    <div v-if="form.errors.url" class="text-danger mt-1">
                                        {{ form.errors.url }}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" v-model="form.nome"
                                            placeholder="Nome Completo">
                                        <div v-if="form.errors.nome" class="text-danger mt-1">
                                            {{ form.errors.nome }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user"
                                            v-model="form.telefone" placeholder="Telefone">
                                        <div v-if="form.errors.telefone" class="text-danger mt-1">
                                            {{ form.errors.telefone }}
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <input type="email" class="form-control form-control-user" v-model="form.email"
                                        placeholder="Email">
                                </div> -->
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Atualizar Pessoa
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
