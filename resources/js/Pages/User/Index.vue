<template>
    <Head title="Usuario del Sistema" />
    <Breadcrumb back-title="Dashboard" back-link="/dashboard" active-title="Usuario del Sistema" />

    <section class="content mt-3">
        <div class="container-fluid">
            <button class="btn btn-primary btn-sm" @click="form_create" data-toggle="modal" data-target="#modalCrud" ><i class="fas fa-plus"></i> Agregar Usuario</button>
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
                    <div v-if="props.column.field == 'roles'">
                        {{ props.row.roles.map(role => role.name).join(', ') }}
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
                                <div class="form-group">
                                    <label for="email" class="col-form-label">Email:</label>
                                    <input type="email" class="form-control"  :class="{'is-invalid': form.errors.email}" id="email" v-model="form.email">
                                    <div v-if="form.errors.email" id="emailFeedback" class="invalid-feedback">
                                        {{ form.errors.email }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-form-label">Contraseña:</label>
                                    <input type="password" class="form-control" id="password" :class="{'is-invalid': form.errors.password}" v-model="form.password">
                                    <div v-if="form.errors.password" id="passwordFeedback" class="invalid-feedback">
                                        {{ form.errors.password }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="role" class="col-form-label">Rol:</label>
                                    <select name="role"  id="role" class="form-control" :class="{'is-invalid': form.errors.role}" v-model="form.role">
                                        <option value="">Seleccione Uno</option>
                                        <option v-for="role in roles" :value="role.name">{{ role.name }}</option>
                                    </select>
                                    <div v-if="form.errors.role" id="roleFeedback" class="invalid-feedback">
                                        {{ form.errors.role }}
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
            name: null,
            email: null,
            password: null,
            role: ''
        })

        return { form }
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
                    label: 'Email',
                    field: 'email',
                    filterOptions: {
                        enabled: true,
                        placeholder: 'Buscar por Email',
                    },
                },
                {
                    label: "Roles",
                    field: "roles",
                    slot: "roles",
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
            deleteId : 0,
            roles: []

        };
    },
    methods: {
        loadItems() {
            axios.post('user/getData', this.serverParams).then(response => {
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
            this.title_modal = 'Agregar Usuario';
            this.crud = 'create';
        },
        form_show(id){
            this.title_modal = 'Actualizar Usuario';
            this.crud = 'update';
            this.updateId = id;
            this.show();

        },

        show() {
            const url = `/users/${this.updateId}`;
            axios.get(url)
                .then((response) => {
                    this.form.name = response.data.name;
                    this.form.email = response.data.email;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        delete(){
            const url = `/users/${this.deleteId}`;
            axios.delete(url)
                .then((response) => {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Usuario Eliminado!',
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
                title: 'Vas a Elimminar el usuario?',
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
                    this.form.post('/users', {
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
                    this.form.put(`/users/${this.updateId}`, {
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

        getRoles() {
            axios.get('user/getRoles').then(response => {
                this.roles = response.data;
            });
        },


    },
    mounted() {
      this.loadItems();
      this.getRoles();
    }

}
</script>
