<template>
   <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img 
                :src="ruta + '/img/adminLTELogo.png'"
                alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3"
                style="opacity: .8">
        <span class="brand-text font-weight-light">Tienda Virtual</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img 
                    :src="ruta + '/img/avatar.png'"
                    class="img-circle elevation-2"
                    alt="User Image"
                >
        </div>
        <div class="info">
            <a href="#" class="d-block">Jaime Díaz</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview menu-open">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>                
            </li>
    <li class="nav-header">OPERACIONES</li>
    <li class="nav-item">
        <router-link class="nav-link" :to="'/pedido'">
            <i class="nav-icon fas fa-cash-register"></i>
            <p>
                Pedidos
            </p>
        </router-link>
    </li>
    <li class="nav-item">
        <router-link class="nav-link" :to="'/cliente'">
            <i class="nav-icon fas fa-user-friends"></i>
            <p>
                Clientes
            </p>
        </router-link>
    </li>

    <li class="nav-header">CONFIGURACIÓN</li>
    <li class="nav-item">
        <router-link class="nav-link" :to="'/categoria'">
            <i class="nav-icon fas fa-sitemap"></i>
            <p>Categorías</p>
        </router-link>
    </li>

    <li class="nav-item">
        <router-link class="nav-link" :to="'/producto'">
            <i class="nav-icon fas fa-apple-alt"></i>
            <p>Productos</p>
        </router-link>
    </li>

    <li class="nav-header">ADMINISTRACIÓN</li>

    <li class="nav-item">
        <router-link class="nav-link" :to="'/usuario'">
            <i class="nav-icon fas fa-users"></i>
            <p>Usuarios</p>
        </router-link>
    </li>
    <li class="nav-item">
        <router-link class="nav-link" :to="'/rol'">
            <i class="nav-icon fas fa-unlock-alt"></i>
            <p>Roless</p>
        </router-link>
    </li>
    <li class="nav-item">
        <router-link class="nav-link" :to="'/permiso'">
            <i class="nav-icon fas fa-fa-key"></i>
            <p>Permisos</p>
        </router-link>
    </li>

    <li class="nav-header">REPORTES</li>

    <li class="nav-item">
        <router-link class="nav-link" :to="'/reporte'">
            <i class="nav-icon fas fa-file-export"></i>
            <p>Pedidos</p>
        </router-link>
    </li>
    </ul>
    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    </aside>
</template>

<script>
export default {
    props: ['ruta'],
}
</script>

<style>

</style>