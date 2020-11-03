<template>
    <div>
	    <!-- Navbar -->
        <NavBar :ruta="ruta" :listPermisos="listRolPermisosByUsuario" :usuario="authUser" />
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <Sidebar :ruta="ruta" :usuario="authUser" :listPermisos="listRolPermisosByUsuario" />
        <!-- Content Wrapper. Contains page content -->

        <!-- Content -->
        <!--<Content />-->
        <div class="content-wrapper">
            <transition name="slide-fade" mode="out-in">
                <router-view></router-view>
            </transition>            
        </div>        
        <!-- /.content-wrapper -->

        <Footer />
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->        
    </div>
</template>

<script>
    import NavBar from './plantilla/Navbar'
    import Sidebar from './plantilla/Sidebar'
    import Footer from './plantilla/Footer'
    export default {
        props: ['ruta', 'usuario'],
        data() {
            return {
                authUser: this.usuario,
                listRolPermisosByUsuario: [],
            }
        },
        components: {
            NavBar,
            Sidebar,
            Footer
        },

        mounted() {
            console.log("### APP.VUE ### SESSION STORATE: ", JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')));
            this.listRolPermisosByUsuario = JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario'));

            // TODO: event-listener
            EventBus.$on('verifyAuthenticatedUser', data => {
                console.log("### TEST APP.VUE ### : ", data);
                this.authUser = data;
            });

            EventBus.$on('notifyRolPermisosByUsuario', data => {
                console.log("actualizando la data from APP:: ", data.length);
                this.listRolPermisosByUsuario = [];
                this.listRolPermisosByUsuario = data;                
            });
        }
    }
</script>

<style>

</style>