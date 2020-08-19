<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Usuario</h1>
                    </div><!-- /.col -->            
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="content container-fluid">
            <div class="row">

                <!-- ASIDE - IZQUIERDA -->
                <div class="col-md-4">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center justify-content-center">
                                <template v-if="!fillVerUsuario.cRutaArchivo">
                                    <img 
                                        src="/img/avatar.png" 
                                        alt="User Profile picture" 
                                        class="profile-user-img img-fluid rounded-circle custom-user-avatar"
                                    />
                                </template>
                                <template v-else>
                                    <div class="col-xs-7">
                                    <img 
                                        :src="fillVerUsuario.cRutaArchivo" 
                                        :alt="compCNombreCompleto" 
                                        class="profile-avatar-img img-fluid rounded-circle custom-user-avatar"
                                    />
                                    </div>
                                </template>                                
                                <!-- <img class="profile-user-img img-fluid img-circle" src="/img/user4-128x128.jpg" alt="User profile picture"> -->
                            </div>
                            <!-- INFO -->
                            <h3 class="profile-username text-center">
                                {{ fillVerUsuario.cPrimerNombre + ' ' + fillVerUsuario.cSegundoNombre + ' ' + fillVerUsuario.cApellido }}
                            </h3>
                            <p class="text-muted text-center">Vendedor</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fab fa-mailchimp mr-1"></i> Nombre Completo</strong>
                            <p class="text-muted" v-text="compCNombreCompleto"></p>
                            <hr>
                            <strong><i class="fas fa-envelope-open-text mr-1"></i> Correo Electronico</strong>
                            <p class="text-muted" v-text="fillVerUsuario.cCorreo"></p>
                        </div>
                    <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <!-- FORMULARIO -->
                <div class="col-md-8">
                    <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                        

                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Nombre</label>
                                <div class="col-md-9">
                                    <el-input
                                        placeholder="Ingrese su Nombre"
                                        clearable
                                        v-model="fillEditarUsuario.cPrimerNombre"
                                        @keyup.enter="setEditarUsuario"
                                    >
                                    </el-input>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Segundo Nombre</label>
                                <div class="col-md-9">
                                    <el-input
                                        placeholder="Ingrese su Segundo Nombre"
                                        clearable
                                        v-model="fillEditarUsuario.cSegundoNombre"
                                        @keyup.enter="setEditarUsuario"
                                    >
                                    </el-input>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Apellido</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" v-model="fillEditarUsuario.cApellido" @keyup.enter="setEditarUsuario">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Usuario</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" v-model="fillEditarUsuario.cUsuario" @keyup.enter="setEditarUsuario">
                                </div>                                
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Correo Electrónico</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" v-model="fillEditarUsuario.cCorreo" @keyup.enter="setEditarUsuario">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Contraseña</label>
                                <div class="col-md-9">
                                    <el-input 
                                        placeholder="Please input password" 
                                        show-password
                                        v-model="fillEditarUsuario.cContrasena"
                                        @keyup.enter="setEditarUsuario"
                                    ></el-input>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Fotografía</label>
                                <div class="col-md-9">
                                    <input type="file" class="form-control" @change="getFile">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button 
                                        class="btn btn-flat btn-info btn-full" 
                                        @click.prevent="setEditarUsuario"
                                        v-loading.fullscreen.lock="fullscreenLoading"
                                    >Editar</button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
          
                </div>                          
            </div>
        </div>

        <!-- MODAL -->
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
            fillEditarUsuario: {
                nIdUsuario     : this.$attrs.id,
                cPrimerNombre  : '',
                cSegundoNombre : '',
                cApellido      : '',
                cApellidos     : '',
                cUsuario       : '',
                cCorreo        : '',
                cContrasena    : '',
                oFotografia    : '',
            },

            fillVerUsuario: {
                nIdUsuario     : this.$attrs.id,
                cPrimerNombre  : '',
                cSegundoNombre : '',
                cApellido      : '',
                cApellidos     : '',
                cUsuario       : '',
                cCorreo        : '',
                cContrasena    : '',
                oFotografia    : '',
                cRutaArchivo   : '',
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
    mounted() {
        // al cargar el componente, obtener info. del usuario seleccionado
        // con base en el id Pasado.
        console.log("mounthed");
        this.getUsuarioById ();
    },
    computed: {
        compCNombreCompleto()
        {
            return this.fillVerUsuario.cPrimerNombre + ' ' + this.fillVerUsuario.cSegundoNombre + ' ' + this.fillVerUsuario.cApellido;
        }
    },    
    methods: {
        getUsuarioById()
        {
            this.fullscreenLoading = true;
            var url = '/administracion/usuario/getListarUsuarios'

            axios.get(url, {
                params: {
                    'nIdUsuario'   :  this.fillEditarUsuario.nIdUsuario
                }
            }).then( response => {
                console.log(response);
                this.getUsuarioEditar(response.data[0]);
                this.getUsuarioVer(response.data[0]);
                this.fullscreenLoading = false;
            })
        },

        // CARGAR LA INFORMACIÓN
        getUsuarioEditar (dataResponse)
        {
            // datos usuario
            this.fillEditarUsuario.cPrimerNombre    =       dataResponse.firstname;
            this.fillEditarUsuario.cSegundoNombre   =       dataResponse.secondname;
            this.fillEditarUsuario.cApellido        =       dataResponse.lastname;
            this.fillEditarUsuario.cUsuario         =       dataResponse.username;
            this.fillEditarUsuario.cCorreo          =       dataResponse.email;
        },

        getUsuarioVer (dataResponse)
        {
            // datos usuario
            this.fillVerUsuario.cPrimerNombre    =       dataResponse.firstname;
            this.fillVerUsuario.cSegundoNombre   =       dataResponse.secondname;
            this.fillVerUsuario.cApellido        =       dataResponse.lastname;
            this.fillVerUsuario.cUsuario         =       dataResponse.username;
            this.fillVerUsuario.cCorreo          =       dataResponse.email;
            this.fillVerUsuario.cRutaArchivo     =       dataResponse.profile_image
        },

        // MODAL
        abrirModal ()
        {
            this.modalShow = !this.modalShow;
        },

        setEditarUsuario ()
        {
            // TODO: comentado
            if ( this.validarRegistrarUsuario() ) {
                this.modalShow = true
                return;
            }

            this.fullscreenLoading = true;

            console.log(this.fillEditarUsuario.oFotografia);
            if ( !this.fillEditarUsuario.oFotografia){
                console.log("no foto");
            }

            //return;

            if ( !this.fillEditarUsuario.oFotografia || this.fillEditarUsuario.oFotografia == undefined ) {
                this.setGuardarUsuarioSinFotografia()
            }
            else
            {
                this.setGuardarUsuarioConFotografia()                
            }
        },

        setGuardarUsuarioConFotografia()
        {
            this.form.append('file', this.fillEditarUsuario.oFotografia)
            const config = { headers: { 'Content-Type': 'multipart/form-data' } }
            var url = '/archivo/setRegistrarArchivo'

            axios.post(url, this.form, config)
                 .then( response => {
                     var nIdFile = response.data[0].nIdFile
                     this.setGuardarUsuario(nIdFile)
                 })
                 .catch(err => console.log("error"))
        },
        
        setGuardarUsuarioSinFotografia()
        {
            this.setGuardarUsuario(0)
        },        

        setGuardarUsuario(nIdFile)
        {
            var url = '/administracion/usuario/setEditarUsuario'
            axios.post(url, {
                'nIdUsuario'        : this.fillEditarUsuario.nIdUsuario,
                'cPrimerNombre'     : this.fillEditarUsuario.cPrimerNombre,
                'cSegundoNombre'    : this.fillEditarUsuario.cSegundoNombre,
                'cApellido'         : this.fillEditarUsuario.cApellido,
                'cUsuario'         : this.fillEditarUsuario.cUsuario,
                'cCorreo'           : this.fillEditarUsuario.cCorreo,
                'cContrasena'       : this.fillEditarUsuario.cContrasena,
                'oFotografia'       : nIdFile
            }).then( respuesta => {
                console.log("registro editado exitosamente")
                this.fullscreenLoading = false;   
                this.getUsuarioById();
                // position: 'top-end',

                Swal.fire({                    
                    icon: 'success',
                    title: 'Se actualizó el usuario correctamente',
                    showConfirmButton: false,
                    timer: 1500
                })         
            }).catch( error => console.log(error))
        },

        limpiarFormulario ()
        {
            this.fillEditarUsuario.cPrimerNombre     = ''
            this.fillEditarUsuario.cSegundoNombre    = ''
            this.fillEditarUsuario.cApellidos        = ''
            this.fillEditarUsuario.cApellido         = ''
            this.fillEditarUsuario.cuUsuario         = ''
            this.fillEditarUsuario.cCorreo           = ''
            this.fillEditarUsuario.cContrasena       = ''
            this.fillEditarUsuario.oFotografia       = ''
        },

        // Archivos
        getFile(e)
        {
            this.fillEditarUsuario.oFotografia = e.target.files[0];
        },

        // VALIDACIONES
        validarRegistrarUsuario ()
        {
            this.error = 0
            this.mensajeError = []

            if ( !this.fillEditarUsuario.cPrimerNombre ) {
                this.mensajeError.push('El primer nombre es un campo obligatorio')
            }

            if ( !this.fillEditarUsuario.cApellido ) {
                this.mensajeError.push('El Apellido es un campo obligatorio')
            }
            
            if ( !this.fillEditarUsuario.cUsuario ) {
                this.mensajeError.push('El Usuario es un campo obligatorio')
            }

            if ( !this.fillEditarUsuario.cCorreo ) {
                this.mensajeError.push('El correo electrónico es un campo obligatorio')
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