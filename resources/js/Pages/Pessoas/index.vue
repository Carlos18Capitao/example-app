<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    pessoas: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <AppLayout>
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Tables</h1>
            <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                For more information about DataTables, please visit the <a target="_blank"
                    href="https://datatables.net">official DataTables documentation</a>.</p>

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
                <div class="card-body">
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
                </div>
            </div>
        </div>
    </AppLayout>
</template>
