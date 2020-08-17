<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Crear Usuario</h1>
                </div><!-- /.col -->            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <router-link class="btn btn-info btn-sm" :to="'/usuario'">
                        <i class="fas fa-arrow-left"></i>
                        Regresar
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Formulario Registrar Usuario</h3>
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
                                                    v-model="fillCrearUsuario.cPrimerNombre"
                                                    @keyup.enter="setRegistrarUsuario"
                                                >
                                                </el-input>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Segundo Nombre</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillCrearUsuario.cSegundoNombre" @keyup.enter="setRegistrarUsuario">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Apellido</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillCrearUsuario.cApellidos" @keyup.enter="setRegistrarUsuario">
                                            </div>
                                        </div>
                                    </div>                                    

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Usuario</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillCrearUsuario.cUsuario" @keyup.enter="setRegistrarUsuario">
                                            </div>
                                        </div>
                                    </div>                                    

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Correo Electrónico</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillCrearUsuario.cCorreo" @keyup.enter="setRegistrarUsuario">
                                            </div>
                                        </div>
                                    </div>                                       
                                    
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Contraseña</label>
                                            <div class="col-md-9">
                                                <el-input 
                                                    placeholder="Please input password" 
                                                    show-password
                                                    v-model="fillCrearUsuario.cContrasena"
                                                    @keyup.enter="setRegistrarUsuario"
                                                ></el-input>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Fotografía</label>
                                            <div class="col-md-9">
                                                <input type="file" class="form-control" @change="getFile">
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
                                        @click.prevent="setRegistrarUsuario"
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
            fillCrearUsuario: {
                cPrimerNombre  : '',
                cSegundoNombre : '',
                cApellidos : '',
                cUsuario       : '',
                cCorreo        : '',
                cContrasena    : '',
                oFotografia    : '',
            },
            // NEGOCIO
            form: new FormData,
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
        setRegistrarUsuario ()
        {
            // TODO: comentado
            if ( this.validarRegistrarUsuario() ) {
                this.modalShow = true
                return;
            }

            this.fullscreenLoading = true;

            console.log(this.fillCrearUsuario.oFotografia);
            if ( !this.fillCrearUsuario.oFotografia){
                console.log("no foto");
            }

            //return;

            if ( !this.fillCrearUsuario.oFotografia || this.fillCrearUsuario.oFotografia == undefined ) {
                this.setGuardarUsuarioSinFotografia()
            }
            else
            {
                this.setGuardarUsuarioConFotografia()                
            }
        },

        setGuardarUsuarioConFotografia()
        {
            this.form.append('file', this.fillCrearUsuario.oFotografia)
            const config = { headers: { 'Content-Type': 'multipart/form-data' } }
            var url = '/archivo/setRegistrarArchivo'

            axios.post(url, this.form, config)
                 .then( response => {
                     var nIdFile = response.data[0].nIdFile
                     this.setGuardarUsuario(nIdFile)
                 })
                 .catch(err => console.log("error"))
        },

        setGuardarUsuario(nIdFile)
        {
            var url = '/administracion/usuario/setRegistrarUsuario'
            axios.post(url, {
                'cPrimerNombre'     : this.fillCrearUsuario.cPrimerNombre,
                'cSegundoNombre'    : this.fillCrearUsuario.cSegundoNombre,
                'cApellido'         : this.fillCrearUsuario.cApellidos,
                'cuUsuario'         : this.fillCrearUsuario.cUsuario,
                'cCorreo'           : this.fillCrearUsuario.cCorreo,
                'cContrasena'       : this.fillCrearUsuario.cContrasena,
                'oFotografia'       : nIdFile
            }).then( respuesta => {
                console.log("registro creado exitosamente")
                this.fullscreenLoading = false;
                this.$router.push('/usuario');

            }).catch( error => console.log(error))
        },

        setGuardarUsuarioSinFotografia()
        {
            this.setGuardarUsuario(0)
        },

        limpiarFormulario ()
        {
            this.fillCrearUsuario.cPrimerNombre     = ''
            this.fillCrearUsuario.cSegundoNombre    = ''
            this.fillCrearUsuario.cApellidos        = ''
            this.fillCrearUsuario.cApellido         = ''
            this.fillCrearUsuario.cuUsuario         = ''
            this.fillCrearUsuario.cCorreo           = ''
            this.fillCrearUsuario.cContrasena       = ''
            this.fillCrearUsuario.oFotografia       = ''
        },

        // Archivos
        getFile(e)
        {
            this.fillCrearUsuario.oFotografia = e.target.files[0];
        },

        // MODAL
        abrirModal ()
        {
            this.modalShow = !this.modalShow;
        },

        // VALIDACIONES
        validarRegistrarUsuario ()
        {
            this.error = 0
            this.mensajeError = []

            if ( !this.fillCrearUsuario.cPrimerNombre ) {
                this.mensajeError.push('El primer nombre es un campo obligatorio')
            }

            if ( !this.fillCrearUsuario.cApellidos ) {
                this.mensajeError.push('El Apellido es un campo obligatorio')
            }
            
            if ( !this.fillCrearUsuario.cUsuario ) {
                this.mensajeError.push('El Usuario es un campo obligatorio')
            }

            if ( !this.fillCrearUsuario.cCorreo ) {
                this.mensajeError.push('El correo electrónico es un campo obligatorio')
            }

            if ( !this.fillCrearUsuario.cContrasena ) {
                this.mensajeError.push('La contraseña es un campo obligatorio')
            }

            if (this.mensajeError.length) {
                this.error = 1
            }

            return this.error
        }
    }   
}
</script>

<style>

</style>