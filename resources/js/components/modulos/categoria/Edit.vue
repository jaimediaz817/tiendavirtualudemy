<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Editar Categoria</h1>
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
                            <h3 class="card-title">Formulario Editar Categoria</h3>
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
                                                    v-model="fillEditarCategoria.cNombre"
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
                                                    v-model="fillEditarCategoria.cDescripcion"
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
            fillEditarCategoria: {
                nIdCategoria: this.$attrs.id,
                cNombre  : '',
                cDescripcion : '',
            },
            listCategorias: [],

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
        setEditarCategoria()
        {
            if (this.validarEditarCategoria()) {
                this.modalShow = true;
                return;                
            }

            this.fullscreenLoading = true;

            var url = '/configuracion/categoria/setEditarCategoria'
            axios.post(url, {
                'nIdCategoria'       : this.fillEditarCategoria.nIdCategoria,
                'cNombre'            : this.fillEditarCategoria.cNombre,
                'cDescripcion'       : this.fillEditarCategoria.cDescripcion
            }).then( respuesta => {
                this.fullscreenLoading = false;
                Swal.fire({                    
                    icon: 'success',
                    title: 'Se actualizó correctamente la categoría',
                    showConfirmButton: false,
                    timer: 1500
                })                   
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

        getListarCategorias() 
        {
            this.fullscreenLoading = true;
            var url = '/configuracion/categoria/getListarCategorias'

            axios.get(url, {
                params: {
                    'nIdCategoria'  :  this.fillEditarCategoria.nIdCategoria
                }
            }).then( response => {
                //this.inicializarPaginacion();
                console.log(response.data);                
                this.fillEditarCategoria.cNombre      =   response.data[0].name;
                this.fillEditarCategoria.cDescripcion =   response.data[0].description 
                this.fullscreenLoading = false;
            }).catch(error => {
                console.log("error::::")
                if (error.response.data.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    this.fullscreenLoading = false;
                }
            })
        },        

        limpiarFormulario ()
        {
            this.fillEditarCategoria.cNombre         = ''
            this.fillEditarCategoria.cDescripcion    = ''
        },

        // MODAL
        abrirModal ()
        {
            this.modalShow = !this.modalShow;
        },

        // VALIDACIONES
        validarEditarCategoria ()
        {
            this.error = 0
            this.mensajeError = []

            if ( !this.fillEditarCategoria.cNombre ) {
                this.mensajeError.push('El nombre es un campo obligatorio')
            }

            // if ( !this.fillEditarCategoria.cDescripcion ) {
            //     this.mensajeError.push('La Descripción es un campo obligatorio')
            // }            

            if (this.mensajeError.length) {
                this.error = 1
            }

            return this.error
        },
    },
    mounted(){
        this.getListarCategorias();
    },
}
</script>

<style>

</style>