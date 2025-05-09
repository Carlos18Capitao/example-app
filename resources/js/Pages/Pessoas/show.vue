<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { router, useForm } from '@inertiajs/vue3';


defineProps({
    pessoa: {
        type: Object,
        required: true
    }
});

function handleFileChange(event, casaId) {
    console.log('handleFileChange', event, casaId);
    const files = event.target.files;

    if (!files.length) return;

    const formData = new FormData();
    for (let i = 0; i < files.length; i++) {
        formData.append('url[]', files[i]);
    }

    router.post(route('casas.photos.store', casaId), formData, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            console.log('Fotos enviadas!');
        },
    });
}

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
                                <img v-if="pessoa.photos && pessoa.photos.length > 0" class="img-profile rounded-circle"
                                    :src="pessoa.photos[0].url" style="width: 100px; height: 100px; object-fit: cover;">
                                <img v-else class="img-profile rounded-circle"
                                    src="/startbootstrap/img/undraw_profile.svg">
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
                        <h6 class="m-0 font-weight-bold text-primary">{{ casa.endereco }} {{ casa.id }}</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink" style="">
                                <div class="dropdown-header">Opções:</div>
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

                        <label :for="'fotocasa-' + casa.id" class="custom-file-upload mt-1" style="cursor: pointer;">
                            <i class="fas fa-camera fa-sm fa-fw text-gray-800"></i>
                        </label>

                        <input type="file" name="fotocasa" multiple="multiple" accept="image/*"
                            @change="(e) => handleFileChange(e, casa.id)" class="d-none" :id="'fotocasa-' + casa.id">



                        <div class="row">

                            <div class="col-lg-12 my-auto">

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">Sala: {{ casa.sala }}</li>
                                    <li class="list-group-item">Quarto: {{ casa.quarto }}</li>
                                    <li class="list-group-item">Casa de Banho: {{ casa.casaDeBanho }}</li>
                                    <li class="list-group-item">Cozinha: {{ casa.cozinha }}</li>
                                    <li class="list-group-item">Desde: {{ casa.created_at }}</li>
                                </ul>
                            </div>

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
                    <div class="card-footer row" v-if="casa.photos && casa.photos.length > 0">
                        <div v-for="photo in casa.photos" :key="photo.id"
                            class="position-relative m-1 image-wrapper col-lg-4" style="width: 100px; height: 100px;">
                            <!-- Badge visível apenas no hover -->
                            <Link :href="route('casas.photos.destroy', photo.id)" method="delete" as="button"
                                class="badge bg-danger position-absolute top-1 end-0 p-1 delete-badge" type="button">
                            <i class="fas fa-trash text-white"></i>
                            </Link>

                            <!-- Imagem -->
                            <img :src="photo.url" class="img-thumbnail"
                                style="width: 100%; height: 100%; object-fit: cover;" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.image-wrapper .delete-badge {
    display: none;
    cursor: pointer;
    z-index: 2;
}

.image-wrapper:hover .delete-badge {
    display: block;
    transition: all 0.3s ease;
}

.image-wrapper:hover img {
    opacity: 0.6;
}
</style>
