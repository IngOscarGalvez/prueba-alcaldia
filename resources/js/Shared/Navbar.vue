<template>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
            <li class="nav-item">
                <Link :href="route('dashboard.index')" class="nav-link" :class="{ 'active': $page.component === 'Dashboard/Index' }" v-if="$page.props.auth.user.roles.includes('admin')">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Panel de Control</p>
                </Link>
            </li>
            <li class="nav-item">
                <Link :href="route('users.index')" class="nav-link" :class="{ 'active': $page.component === 'User/Index' }" v-if="$page.props.auth.user.roles.includes('admin')">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Usuarios del Sistema</p>
                </Link>
            </li>
            <!-- Primer elemento con submenu -->
            <li class="nav-item has-treeview" :class="{ 'menu-open': menusOpen[0] }">
                <a href="#" class="nav-link" @click.prevent="toggleMenu(0)">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                        Configuraciones
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <Link :href="route('tipoIdentificacion.index')" class="nav-link" :class="{ 'active': $page.component === 'Config/TipoIdentificacion/Index' }" v-if="$page.props.auth.user.roles.includes('admin')">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Tipo Identificación</p>
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('departamentos.index')" class="nav-link" :class="{ 'active': $page.component === 'Config/Departamentos/Index' }" v-if="$page.props.auth.user.roles.includes('admin')">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Departamentos</p>
                        </Link>
                    </li>

                </ul>
            </li>


        </ul>
    </nav>

</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from 'vue';

export default {
    components: {
        Link,
    },
    setup() {
        // Crea un array para mantener el estado de apertura/cierre de cada submenú
        const menusOpen = ref([false, false]); // Inicializa con false para cada menú

        // Función para alternar el estado de un menú específico
        const toggleMenu = (index) => {
            // Alterna el estado del menú en el índice especificado
            menusOpen.value[index] = !menusOpen.value[index];
        };

        return {
            menusOpen,
            toggleMenu,
        };
    },
}
</script>
