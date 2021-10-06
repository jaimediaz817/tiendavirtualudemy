<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Editar Cliente</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <router-link class="btn btn-info btn-sm" :to="'/cliente'">
                        <i class="fas fa-arrow-left"></i>
                        Regresar
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Formulario Registrar un Cliente</h3>
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
                                                    v-model="fillEditarCliente.cNombre"
                                                    @keyup.enter="setEditarCliente"
                                                >
                                                </el-input>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Apellidos</label>
                                            <div class="col-md-9">
                                                <el-input
                                                    placeholder="Ingrese los Apellidos"
                                                    clearable
                                                    v-model="fillEditarCliente.cApellido"
                                                    @keyup.enter="setEditarCliente"
                                                >
                                                </el-input>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Documento</label>
                                            <div class="col-md-9">
                                                <el-input
                                                    type="number"
                                                    max="20"
                                                    placeholder="Ingrese el Documento"
                                                    clearable
                                                    v-model="fillEditarCliente.cDocumento"
                                                    @keyup.enter="setEditarCliente"
                                                >
                                                </el-input>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Teléfono</label>
                                            <div class="col-md-9">
                                                <el-input
                                                    placeholder="Ingrese el Teléfono"
                                                    clearable
                                                    v-model="fillEditarCliente.cTelefono"
                                                    @keyup.enter="setEditarCliente"
                                                >
                                                </el-input>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-12 col-form-label">Email</label>
                                            <div class="col-md-12">
                                                <vs-input
                                                    v-model="fillEditarCliente.cEmail"
                                                    placeholder="correo@gmail.com"
                                                >
                                                    <template
                                                        v-if="validEmail"
                                                        #message-success
                                                    >Correo electrónico válido</template>
                                                    <template
                                                        v-if="!validEmail && fillEditarCliente.cEmail !== ''"
                                                        #message-danger
                                                    >El correo electrónico no tiene el formato correcto</template>
                                                </vs-input>
                                                <el-input
                                                    type="email"
                                                    placeholder="Ingrese el Correo Electrónico"
                                                    clearable
                                                    v-model="fillEditarCliente.cEmail"
                                                    @keyup.enter="setEditarCliente"
                                                >
                                                </el-input>
                                            </div>
                                        </div>



                                        <!-- <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Email</label>
                                            <div class="col-md-9">
                                                <el-input
                                                    placeholder="Ingrese el Email"
                                                    clearable
                                                    v-model="fillEditarCliente.cEmail"
                                                    @keyup.enter="setEditarCliente"
                                                >
                                                </el-input>
                                            </div>
                                        </div> -->
                                    </div>

                                </div>
                            </form>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                    <div class="col-md-4 offset-4">
                                        <button
                                            class="btn btn-flat btn-info btnWidth"
                                            @click.prevent="setEditarCliente"
                                            v-loading.fullscreen.lock="fullscreenLoading"
                                        >Editar</button>
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
            fillEditarCliente: {
                nIdCliente: this.$attrs.id,
                cNombre  : '',
                cApellido : '',
                cDocumento: '',
                cTelefono: '',
                cEmail: ''
            },

            listClientes: [],
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
        validEmail() {
            return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.fillEditarCliente.cEmail)
        },
    },
    methods: {
        setEditarCliente()
        {
            if (this.validarRegistrarCliente()) {
                this.modalShow = true;
                return;
            }

            this.fullscreenLoading = true;

            var url = '/operacion/cliente/setEditarCliente'
            axios.post(url, {
                'nIdCliente'         : this.fillEditarCliente.nIdCliente,
                'cNombre'            : this.fillEditarCliente.cNombre,
                'cApellido'          : this.fillEditarCliente.cApellido,
                'cDocumento'         : this.fillEditarCliente.cDocumento,
                'cTelefono'          : this.fillEditarCliente.cTelefono,
                'cEmail'             : this.fillEditarCliente.cEmail
            }).then( respuesta => {
                this.fullscreenLoading = false;
                this.$router.push('/cliente');
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
            this.fillEditarCliente.cNombre    = ''
            this.fillEditarCliente.cApellido  = ''
            this.fillEditarCliente.cDocumento = ''
            this.fillEditarCliente.cTelefono  = ''
            this.fillEditarCliente.cEmail     = ''
        },

        // MODAL
        abrirModal ()
        {
            this.modalShow = !this.modalShow;
        },

        // VALIDACIONES
        validarRegistrarCliente ()
        {
            this.error = 0
            this.mensajeError = []

            if ( !this.fillEditarCliente.cNombre ) {
                this.mensajeError.push('El nombre es un campo obligatorio')
            }

            if ( !this.fillEditarCliente.cApellido ) {
                this.mensajeError.push('El Apellido es un campo obligatorio')
            }

            if ( !this.fillEditarCliente.cDocumento ) {
                this.mensajeError.push('El Documento es un campo obligatorio')
            }

            if (this.mensajeError.length) {
                this.error = 1
            }

            return this.error
        },

        /* METODOS DE NEGOCIO:
           Listar las categorias del sistema */
        getListarClientes()
        {
            this.fullscreenLoading = true;
            var url = '/operacion/cliente/getListarClientes'

            axios.get(url, {
                params: {
                    'nIdCliente': this.fillEditarCliente.nIdCliente
                }
            }).then( response => {
                if (response.data.length > 0) {
                    this.fillEditarCliente.nIdCliente = response.data[0].id;
                    this.fillEditarCliente.cNombre    = response.data[0].name;
                    this.fillEditarCliente.cApellido  = response.data[0].lastname;
                    this.fillEditarCliente.cDocumento = response.data[0].document;
                    this.fillEditarCliente.cTelefono  = response.data[0].phone;
                    this.fillEditarCliente.cEmail     = response.data[0].email;
                }

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
    mounted()
    {
        this.getListarClientes();
    },
}
</script>

<style>
    div.el-input-number {
        width: 100% !important;
    }
</style>
