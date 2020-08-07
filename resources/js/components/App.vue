<template>
    <div>
	    <!-- Navbar -->
        <NavBar :ruta="ruta"/>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <Sidebar :ruta="ruta" />
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
        props: ['ruta'],
        components: {
            NavBar,
            Sidebar,
            Footer
        }
    }
</script>

<style>

</style>