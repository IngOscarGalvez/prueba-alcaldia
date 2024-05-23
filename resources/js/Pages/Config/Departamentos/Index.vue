<template>
    <Head :title="title" />
    <Breadcrumb back-title="Dashboard" back-link="/dashboard" :active-title="title" />

    <section class="content mt-3">
        <div class="container-fluid">
            <button class="btn btn-primary btn-sm" @click="form_create" data-toggle="modal" data-target="#modalCrud" ><i class="fas fa-plus"></i> Agregar {{title}}</button>
            <br>
            <br>

            <vue-good-table
                mode="remote"
                v-on:page-change="onPageChange"
                v-on:sort-change="onSortChange"
                v-on:column-filter="onColumnFilter"
                v-on:per-page-change="onPerPageChange"
                :totalRows="totalRecords"
                :isLoading="isLoading"
                :pagination-options="{
                    enabled: true,
                }"
                :rows="rows"
                :columns="columns"
                styleClass="vgt-table condensed bordered striped"
                >
                <template #table-row="props">
                    <div v-if="props.column.field == 'id'">
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCrud" @click="form_show(props.row.id)"><i class="fas fa-pencil"></i></button>
                        <button class="btn btn-danger btn-sm" @click="form_delete(props.row.id)"><i class="fas fa-trash"></i></button>
                    </div>
                </template>

            </vue-good-table>
        </div>

        <div class="modal fade" id="modalCrud" tabindex="-1" aria-labelledby="modalCrud" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ title_modal }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <form @submit.prevent="send" autocomplete="off">
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="name" class="col-form-label">Nombre:</label>
                                <input type="text" class="form-control" :class="{'is-invalid': form.errors.name}" id="name" v-model="form.name">
                                <div v-if="form.errors.name" id="nameFeedback" class="invalid-feedback">
                                    {{ form.errors.name }}
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import {Head} from "@inertiajs/vue3";
import Layout from "@Shared/Layout.vue";
import Breadcrumb from "@Shared/Breadcrumb.vue";
import 'vue-good-table-next/dist/vue-good-table-next.css'
import { VueGoodTable } from 'vue-good-table-next';
import { useForm } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';



export default {
    components: {
        Breadcrumb,
        Head,
        VueGoodTable
    },
    layout: Layout,
    setup () {
        const form = useForm({
            name: null
        })

        return { form }
    },
    props :{
        title: {
            type: String,
        },
        name_route: {
            type: String,
        },

    },

    data() {
        return {
            isLoading: false,
            columns: [
                {
                    label: 'Nombre',
                    field: 'name',
                    filterOptions: {
                        enabled: true,
                        placeholder: 'Buscar por Nombre',
                    },
                },

                {
                    label: "Opciones",
                    field: "id",
                    slot: "modify",
                },

            ],
            rows: [],
            totalRecords: 0,
            serverParams: {
                columnFilters: {
                },
                sort: {
                    field: '',
                    type: '',
                },
                page: 1,
                perPage: 10
            },
            paginationOptions: {
                enabled: true,
                perPage: 10,
                perPageDropdown: [10, 20, 50, 100],
                nav: true
            },
            title_modal : '',
            crud : '',
            updateId : 0,
            deleteId : 0

        };
    },
    methods: {
        loadItems() {
            axios.post(`/${this.name_route}/getData`, this.serverParams).then(response => {
                this.rows = response.data.data;
                this.totalRecords = response.data.total
            });
        },
        updateParams(newProps) {
            this.serverParams = Object.assign({}, this.serverParams, newProps);
        },

        onPageChange(params) {
            this.updateParams({page: params.currentPage});
            this.loadItems();
        },

        onPerPageChange(params) {
            this.updateParams({perPage: params.currentPerPage});
            this.loadItems();
        },

        onSortChange(params) {
            this.updateParams({
                sortKey : params[0].field,
                sortOrder : params[0].type,
            });
            this.loadItems();
        },

        onColumnFilter(params) {
            this.updateParams(params);
            this.loadItems();
        },
        form_create(){
            this.title_modal = 'Agregar Dato';
            this.crud = 'create';
        },
        form_show(id){
            this.title_modal = 'Actualizar Dato';
            this.crud = 'update';
            this.updateId = id;
            this.show();

        },

        show() {
            const url = `/${this.name_route}/${this.updateId}`;
            axios.get(url)
                .then((response) => {
                    this.form.name = response.data.name;
                    this.form.number = response.data.number;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        delete(){
            const url = `/${this.name_route}/${this.deleteId}`;
            axios.delete(url)
                .then((response) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Dato Eliminado!',
                        text: 'La información se ha eliminado correctamente.',
                    });
                    this.loadItems();
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        form_delete(id){
            this.deleteId = id;
            Swal.fire({
                title: `Vas a Elimminar la ${this.title}? `,
                showDenyButton: true,
                confirmButtonText: 'Si',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.delete();
                }
            })
        },

        send(){
            switch (this.crud) {
                case 'create':
                    this.form.post(`/${this.name_route}`, {
                        preserveScroll: true,
                        onSuccess: () => {
                            this.form.reset();
                            Swal.fire({
                                icon: 'success',
                                title: '¡Guardado exitoso!',
                                text: 'La información se ha guardado correctamente.',
                            });
                            $('#modalCrud').modal('hide');
                            this.loadItems();
                        },
                    });
                    break;
                case 'update':
                    this.form.put(`/${this.name_route}/${this.updateId}`, {
                        preserveScroll: true,
                        onSuccess: () => {
                            this.form.reset();
                            Swal.fire({
                                icon: 'success',
                                title: '¡Actualización exitosa!',
                                text: 'La información se ha actualizado correctamente.',
                            });
                            $('#modalCrud').modal('hide');
                            this.loadItems();
                        },
                    });
                    break;
            }
        },


    },
    mounted() {
      this.loadItems();
    }

}
</script>
