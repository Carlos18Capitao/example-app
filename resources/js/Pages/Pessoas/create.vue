<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const imagePreview = ref(null);

const form = useForm({
    nome: '',
    telefone: '',
    email: '',
    url: null,
});

const handleFileChange = (event) => {
    const file = event.target.files[0];
    form.url = file;
    
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        imagePreview.value = null;
    }
};

</script>

<template>
    <AppLayout>
        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Nova Pessoa!</h1>
                            </div>
                            <form @submit.prevent="form.post(route('pessoas.store'), {
                                onSuccess: () => form.reset(),
                                preserveScroll: true,
                            })" class="user">
                                <div class="form-group">
                                    <input 
                                    type="file" 
                                    name="url"
                                    class="form-control form-control-user" 
                                    id="url"
                                    style="display: none;"
                                    @change="handleFileChange"
                                    accept="image/*"
                                    >
                                    <div v-if="form.errors.url" class="text-danger mt-1">
                                        {{ form.errors.url }}
                                    </div>
                                    <div v-if="imagePreview" class="mt-3 text-center">
                                        <label for="url" style="cursor: pointer;">
                                            <img :src="imagePreview" 
                                            class="img-profile rounded-circle" 
                                            style="width: 100px; height: 100px; object-fit: cover;"
                                            >
                                        </label>
                                    </div>
                                    <div class="mt-3 text-center" v-else >
                                        <label for="url" style="cursor: pointer;">
                                            <img style="width: 100px; height: 100px; object-fit: cover;" class="img-profile rounded-circle" src="/startbootstrap/img/undraw_profile.svg">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input 
                                            type="text" 
                                            class="form-control form-control-user" 
                                            v-model="form.nome" 
                                            id="nomeCompleto"
                                            placeholder="Nome Completo"
                                        >
                                        <div v-if="form.errors.nome" class="text-danger mt-1">
                                            {{ form.errors.nome }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input 
                                            type="text" 
                                            class="form-control form-control-user" 
                                            v-model="form.telefone" 
                                            id="telefone"
                                            placeholder="Telefone"
                                        >
                                        <div v-if="form.errors.telefone" class="text-danger mt-1">
                                            {{ form.errors.telefone }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input 
                                        type="email" 
                                        class="form-control form-control-user" 
                                        v-model="form.email" 
                                        id="email"
                                        placeholder="Email"
                                    >
                                    <div v-if="form.errors.email" class="text-danger mt-1">
                                        {{ form.errors.email }}
                                    </div>
                                </div>

                                <button 
                                    type="submit" 
                                    class="btn btn-primary btn-user btn-block"
                                    :disabled="form.processing"
                                >
                                    <span v-if="form.processing">Salvando...</span>
                                    <span v-else>Cadastrar</span>
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
