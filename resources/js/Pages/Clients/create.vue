<script setup>
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm, Head } from '@inertiajs/vue3'

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})

const form = useForm({
    nome: '',
    telefone: '',
    email: '',
});

const submit = () => {
    form.post(route('clientes.store'), {
        onSuccess: () => {
            form.reset();
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
}
</script>

<template>
    <AppLayout>

        <Head title="Criar Cliente" />
        <div class="container">
            <div class="row">
                <div class="col-md-5 mx-auto">
                    <div class="card cardbox">
                        <div class="card-body">

                            <div class="form-group">

                                <form @submit.prevent="submit" class="form">

                                    <div class="form-group">
                                        <label class="sr-only">nome</label>
                                        <input type="text" id="reg_nome" name="cliente_name" class="form-control"
                                            v-model="form.nome" placeholder="Nome Completo" required>
                                        <div v-if="form.errors.nome" class="text-danger mt-1">{{ form.errors.nome }}
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="sr-only">Telefone</label>
                                        <input type="text" id="reg_telefone" name="cliente_telefone"
                                            class="form-control" v-model="form.telefone" placeholder="+244 900 000 000"
                                            required>
                                        <div v-if="form.errors.telefone" class="text-danger mt-1">{{
                                            form.errors.telefone }}
                                        </div>

                                    </div>

                                    <!-- email group -->
                                    <div class="form-group">
                                        <label class="sr-only">E-mail</label>
                                        <input type="email" id="reg_email" name="cliente_email" class="form-control"
                                            v-model="form.email" placeholder="xxx@xxx.com">
                                        <div v-if="form.errors.email" class="text-danger mt-1">{{ form.errors.email }}
                                        </div>

                                    </div>

                                    <!-- Submit -->
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block btn-primary">Salvar</button>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<style scoped>
.row {
    margin-top: 50px;
    margin-bottom: 50px;
}

.masthead-text {
    height: 300px;
}

.form-control {
    height: 45px;
}

select:hover {
    color: #444645;
    background: #ddd;
}

.login-or {
    position: relative;
    font-size: 18px;
    color: #aaa;
    margin-top: 20px;
    margin-bottom: 20px;
    padding-top: 10px;
    padding-bottom: 10px;
}

.span-or {
    display: block;
    position: absolute;
    left: 50%;
    top: -2px;
    margin-left: -25px;
    background-color: #fff;
    width: 50px;
    text-align: center;
}

.hr-or {
    background-color: #cdcdcd;
    height: 1px;
    margin-top: 0px !important;
    margin-bottom: 0px !important;
}

#login-dp {
    min-width: 250px;
    padding: 14px 14px 0;
    overflow: hidden;
    background-color: rgba(255, 255, 255, .8);
}

#login-dp .help-block {
    font-size: 12px
}

#login-dp .social-buttons {
    margin: 12px 0
}

#login-dp .social-buttons a {
    width: 49%;
}

#login-dp .form-group {
    margin-bottom: 10px;
}

.btn-fb {
    color: #fff;
    background-color: #3b5998;
}

.btn-fb:hover {
    color: #fff;
    background-color: #496ebc
}

.btn-tw {
    color: #fff;
    background-color: #55acee;
}

.btn-tw:hover {
    color: #fff;
    background-color: #59b5fa;
}

@media(max-width:768px) {
    #login-dp {
        background-color: inherit;
        color: #fff;
    }

    #login-dp .bottom {
        background-color: inherit;
        border-top: 0 none;
    }
}

.progress {
    height: 5px;
}

.block-help {
    font-weight: 300;
}

.hide {
    display: none;
}
</style>