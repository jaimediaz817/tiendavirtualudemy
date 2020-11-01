<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Crear Producto</h1>
                </div><!-- /.col -->            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <router-link class="btn btn-info btn-sm" :to="'/producto'">
                        <i class="fas fa-arrow-left"></i>
                        Regresar
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Formulario Registrar un Producto</h3>
                        </div>
                        <div class="card-body">
                            <form role="form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Nombre</label>
                                            <div class="col-md-9">
                                                <el-input
                                                    placeholder="Ingrese su Nombre"
                                                    clearable
                                                    v-model="fillCrearProducto.cNombre"
                                                    @keyup.enter="setRegistrarProducto"
                                                >
                                                </el-input>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Descripción</label>
                                            <div class="col-md-9">
                                                <el-input
                                                    placeholder="Ingrese la url amigable"
                                                    clearable
                                                    v-model="fillCrearProducto.cDescripcion"
                                                    @keyup.enter="setRegistrarProducto"
                                                >
                                                </el-input>
                                            </div>
                                        </div>
                                    </div>                                  

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Stock</label>
                                            <div class="col-md-9">
                                                <!-- <el-input
                                                    placeholder="Ingrese el Stock"
                                                    clearable
                                                    v-model="fillCrearProducto.nStock"
                                                    @keyup.enter="setRegistrarProducto"
                                                >
                                                </el-input> -->
                                                <el-input-number 
                                                    placeholder="Ingrese el Stock"
                                                    controls-position="right"
                                                    clearable
                                                    v-model="fillCrearProducto.nStock"
                                                    @keyup.enter="setRegistrarProducto"
                                                    :min="1" 
                                                    :controls=false
                                                >
                                                </el-input-number>                                                
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Precio</label>
                                            <div class="col-md-9">
                                                <!-- <el-input
                                                    placeholder="Ingrese el Stock"
                                                    clearable
                                                    v-model="fillCrearProducto.fPrice"
                                                    @keyup.enter="setRegistrarProducto"
                                                >
                                                </el-input> -->

                                                <el-input-number 
                                                    placeholder="Ingrese el valor del Producto"
                                                    controls-position="right"
                                                    clearable
                                                    v-model="fillCrearProducto.fPrice"
                                                    @keyup.enter="setRegistrarProducto"                                                    
                                                    :min="1" 
                                                >
                                                </el-input-number>                                                  
                                            </div>
                                        </div>
                                    </div>  

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Categoría</label>
                                            <div class="col-md-9">
                                                <el-select 
                                                    v-model="fillCrearProducto.nIdCategoria" 
                                                    placeholder="Seleccione una Categoría"
                                                    clearable
                                                >
                                                        <el-option
                                                            v-for="item in listCategorias"
                                                            :key="item.id"
                                                            :label="item.name"
                                                            :value="item.id"
                                                        >
                                                        </el-option>
                                                </el-select>
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
                                            @click.prevent="setRegistrarProducto"
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
            fillCrearProducto: {
                cNombre  : '',
                cDescripcion : '',
                fPrice: 1,
                nStock: 1,
                nIdCategoria: ''
            },

            listCategorias: [],
            fillBusquedaProducto: {
                cNombre  : '',
                cDescripcion : '',
                nIdCategoria: ''
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
        setRegistrarProducto()
        {
            if (this.validarRegistrarProducto()) {
                this.modalShow = true;
                return;                
            }

            this.fullscreenLoading = true;

            var url = '/configuracion/producto/setRegistrarProducto'
            axios.post(url, {
                'cNombre'            : this.fillCrearProducto.cNombre,
                'cDescripcion'       : this.fillCrearProducto.cDescripcion,
                'nStock'             : this.fillCrearProducto.nStock,
                'fPrice'             : this.fillCrearProducto.fPrice,
                'nIdCategoria'       : this.fillCrearProducto.nIdCategoria
            }).then( respuesta => {
                this.fullscreenLoading = false;
                this.$router.push('/producto');
            }).catch(error => {
                console.log("error::::")
                if (error.response.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    this.fullscreenLoading = false;
                }
            });
        },

        limpiarFormulario ()
        {
            this.fillCrearProducto.cNombre         = ''
            this.fillCrearProducto.cDescripcion    = ''
            this.fillCrearProducto.nStock          = 1
            this.fillCrearProducto.fPrice          = 1
            this.fillCrearProducto.nIdCategpria    = ''
        },

        // MODAL
        abrirModal ()
        {
            this.modalShow = !this.modalShow;
        },

        // VALIDACIONES
        validarRegistrarProducto ()
        {
            this.error = 0
            this.mensajeError = []

            if ( !this.fillCrearProducto.cNombre ) {
                this.mensajeError.push('El nombre es un campo obligatorio')
            }

            if ( !this.fillCrearProducto.nIdCategoria ) {
                this.mensajeError.push('La categoría es un campo obligatorio, por favor seleccionarlo del listado.')
            }            

            // if ( !this.fillCrearProducto.cDescripcion ) {
            //     this.mensajeError.push('La Descripción es un campo obligatorio')
            // }            

            if (this.mensajeError.length) {
                this.error = 1
            }

            return this.error
        },

        /* METODOS DE NEGOCIO:
           Listar las categorias del sistema */
        getListarCategorias() 
        {
            this.fullscreenLoading = true;
            var url = '/configuracion/categoria/getListarCategorias'

            axios.get(url).then( response => {             
                this.listCategorias = response.data;
                this.fullscreenLoading = false;
            }).catch(error => {
                if (error.response.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    this.fullscreenLoading = false;
                }
            });
        },

    },
    mounted(){
        // ...
        this.getListarCategorias();
    },
}
</script>

<style>
    div.el-input-number {
        width: 100% !important;
    }
</style>