<template>
    <div class="wrapper">

        <!--<div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>-->

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <TopBarLink :href="route('dashboard.index')">Dashboard</TopBarLink>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">{{ auth.user.name }}</a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <Link class="dropdown-item" href="/logout" method="delete" type="button" as="button">
                            <div class="d-flex align-items-center justify-content-between">
                                <p>Logout</p>
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                        </Link>
                    </div>
                </li>
            </ul>
        </nav>


        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <Link :href="route('dashboard.index')" class="brand-link">
                <span class="brand-text font-weight-light"><b>Gestión de Empleados</b></span>
            </Link>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <!-- <div class="image">
                        <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div> -->
                    <div class="info">
                        <a href="#" class="d-block">{{ auth.user.name }}</a>
                    </div>
                </div>

                <Navbar />

            </div>

        </aside>

        <div class="content-wrapper">

            <slot/>

        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2024 <a href="#"><b>Gestión de Empleados</b></a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>


    </div>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3'
import Navbar from "@Shared/Navbar.vue";
import TopBarLink from "@Components/top-bar/TopBarLink.vue";

export default {
    components: {
        TopBarLink,
        Navbar,
        Link,
    },
    props: {
        auth: Object,
    },

}
</script>
