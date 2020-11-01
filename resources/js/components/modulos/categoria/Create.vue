<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Crear Categoria</h1>
                </div><!-- /.col -->            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <router-link class="btn btn-info btn-sm" :to="'/categoria'">
                        <i class="fas fa-arrow-left"></i>
                        Regresar
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Formulario Registrar Categoria</h3>
                        </div>
                        <div class="card-body">
                            <form role="form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Nombre</label>
                                            <div class="col-md-9">
                                                <el-input
                                                    placeholder="Ingrese su Nombre"
                                                    clearable
                                                    v-model="fillCrearCategoria.cNombre"
                                                    @keyup.enter="setRegistrarCategoria"
                                                >
                                                </el-input>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Descripción</label>
                                            <div class="col-md-9">
                                                <el-input
                                                    placeholder="Ingrese la url amigable"
                                                    clearable
                                                    v-model="fillCrearCategoria.cDescripcion"
                                                    @keyup.enter="setRegistrarCategoria"
                                                >
                                                </el-input>
                                            </div>
                                        </div>
                                    </div>                                  

                                </div>
                            </form>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                    <div class="col-md-4 offset-4">
                                        <button 
                                            class="btn btn-flat btn-info btnWidth" 
                                            @click.prevent="setRegistrarCategoria"
                                            v-loading.fullscreen.lock="fullscreenLoading"
                                        >Registrar</button>
                                        <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarFormulario">Limpiar</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" :class="{ show: modalShow }" :style=" modalShow ? mostrarModal : ocultarModal">
        <div class="modal-dialog" role="document">            
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sistema de Laravel y Vue</h5>
                    <button class="close" @click="abrirModal"></button>
                </div>
                <div class="modal-body">
                    <div 
                        v-for="(item, index) in mensajeError" :key="index" v-text="item"
                        class="callout callout-danger"
                        style="padding: 5px"
                    >

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click="abrirModal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            fillCrearCategoria: {
                cNombre  : '',
                cDescripcion : '',
            },

            fullscreenLoading: false,

            // MODALES
            modalShow: false,
            mostrarModal: {
                display: 'block',
                background: '#0000006b'
            },
            ocultarModal: {
                display: 'none',
            },
            // ERRORES
            error: 0,
            mensajeError: [],
        }
    },
    computed: {

    },
    methods: {
        setRegistrarCategoria()
        {
            if (this.validarRegistrarPermisos()) {
                this.modalShow = true;
                return;                
            }

            this.fullscreenLoading = true;

            var url = '/configuracion/categoria/setRegistrarCategoria'
            axios.post(url, {
                'cNombre'            : this.fillCrearCategoria.cNombre,
                'cDescripcion'       : this.fillCrearCategoria.cDescripcion
            }).then( respuesta => {
                this.fullscreenLoading = false;
                this.$router.push('/categoria');
            }).catch(error => {
                console.log("error::::")
                if (error.response.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    this.fullscreenLoading = false;
                }
            })
        },

        limpiarFormulario ()
        {
            this.fillCrearCategoria.cNombre         = ''
            this.fillCrearCategoria.cDescripcion    = ''
        },

        // MODAL
        abrirModal ()
        {
            this.modalShow = !this.modalShow;
        },

        // VALIDACIONES
        validarRegistrarPermisos ()
        {
            this.error = 0
            this.mensajeError = [] 

            if ( !this.fillCrearCategoria.cNombre ) {
                this.mensajeError.push('El nombre es un campo obligatorio')
            }

            // if ( !this.fillCrearCategoria.cDescripcion ) {
            //     this.mensajeError.push('La Descripción es un campo obligatorio')
            // }            

            if (this.mensajeError.length) {
                this.error = 1
            }

            return this.error
        },
    },
    mounted(){
        // ...
    },
}
</script>

<style>

</style>