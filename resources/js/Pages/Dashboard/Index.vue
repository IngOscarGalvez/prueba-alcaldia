<template>
    <Head title="Dashboard" />
    <Breadcrumb back-title="Dashboard" back-link="/dashboard" active-title="Dashboard" />

    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6" v-for="category in categories" :key="category.category_id">
                    <div class="small-box" :class="category.bgClass">
                        <div class="inner">
                            <h3>{{ category.total_items }}</h3>
                            <p>{{ category.category_name }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <!--<a href="#" class="small-box-footer">Mas Información <i class="fas fa-arrow-circle-right"></i></a>-->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div id="accordionExample" class="accordion">
                        <div class="card" v-for="category in categories" :key="category.category_id">
                            <div class="card-header" :id="'heading' + category.category_id">
                                <b>{{ category.category_name }}</b>
                                <div class="btn_header">
                                    <span class="badge badge-light">{{ category.total_items }}</span>
                                    <i class="fa fa-eye ml-2" data-toggle="collapse" :data-target="'#collapse' + category.category_id" aria-expanded="false" :aria-controls="'collapse' + category.category_id"></i>
                                </div>
                            </div>
                            <div :id="'collapse' + category.category_id" class="collapse" :aria-labelledby="'heading' + category.category_id" data-parent="#accordionExample">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item" v-for="component in category.components" :key="component.component_id">
                                            {{ component.component_name }}
                                            <div class="float-right">
                                                <span class="badge badge-primary">{{ component.items_count }}</span>
                                                <Link :href="route('item.index', { id: component.component_id, component: component.component_name })" class="btn-link ml-2" title="Ver">
                                                    <i class="fa fa-eye"></i>
                                                </Link>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </section>
</template>

<script>
import { Head } from "@inertiajs/vue3";
import Layout from "@Shared/Layout.vue";
import Breadcrumb from "@Shared/Breadcrumb.vue";
import { Link } from "@inertiajs/inertia-vue3";
import axios from 'axios';

export default {
    components: {
        Link,
        Breadcrumb,
        Head,
    },
    layout: Layout,
    data() {
        return {
            categories: [],
            bgClasses: ['bg-info', 'bg-warning', 'bg-danger', 'bg-success', 'bg-primary'],
        };
    },
    methods: {
        getCategories() {
            axios.get('dashboard/getCategories').then(response => {
                this.categories = response.data.map((category, index) => ({
                    ...category,
                    bgClass: this.getRandomBgClass(), // Asigna una clase de color de forma aleatoria
                }));
            });
        },
        getRandomBgClass() {
            const randomIndex = Math.floor(Math.random() * this.bgClasses.length);
            return this.bgClasses[randomIndex];
        },
    },
    mounted() {
        this.getCategories();
    },
}
</script>
<style scoped>
/* Ajustes generales para la tarjeta y su cabecera */
.accordion .card {
    background-color: #007bff;
    border: 1px solid #ffffff; /* Borde blanco en la parte inferior de la cabecera */
    border-radius: 0; /* Elimina el radio del borde */
    margin: 0;
}

.accordion .card-header {
    padding: 0.75rem 1.25rem; /* Ajusta el relleno para que coincida con tu diseño */
    background-color: #007bff;
    border-bottom: 1px solid #ffffff; /* Borde blanco en la parte inferior de la cabecera */
    color: #fff;
}

/* Estilo para el título y los elementos dentro de la cabecera */
.accordion .card-header h4 {
    font-size: 1.5rem; /* Tamaño del título */
    color: white; /* Color del texto */
}

.accordion .card-header a {
    color: white; /* Color del texto para el enlace */
    text-decoration: none; /* Elimina el subrayado del enlace */
    display: flex; /* Usa flexbox para organizar los elementos */
    justify-content: space-between; /* Espacia los elementos uniformemente */
    align-items: center; /* Centra los elementos verticalmente */
}

.accordion .card-header a:hover,
.accordion .card-header a:focus {
    text-decoration: none; /* Elimina el subrayado del enlace al pasar el mouse o seleccionar */
}

/* Estilo para el badge */
.badge-light {
    background-color: #ffffff;
    color: #007bff;
}

/* Estilo para el ícono de ojo */
.accordion .card-header i.fa-eye {
    color: white; /* Color del ícono */
}

/* Ajustes para el cuerpo de la tarjeta */
.accordion .card-body {
    background-color: #e7f1ff; /* Color de fondo para el contenido */
}

/* Ajustes para los elementos de lista */
.list-group-item {
    border: 1px solid #ddd; /* Borde blanco en la parte inferior de la cabecera */
}

/* Estilo para los badges dentro del cuerpo de la tarjeta */
.accordion .card-body .badge-primary {
    background-color: #ffc107; /* Color de fondo para el badge */
}

.btn_header{
    position: absolute;
    right: 30px;
    margin-right: -17px;
    margin-top : -25px;
}




</style>
