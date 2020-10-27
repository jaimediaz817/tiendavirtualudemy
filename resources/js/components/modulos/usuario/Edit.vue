<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Editar Usuario</h1>
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
                            <h3 class="card-title">Formulario Editar Usuario</h3>
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
                                                    v-model="fillEditarUsuario.cPrimerNombre"
                                                    @keyup.enter="setEditarUsuario"
                                                >
                                                </el-input>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Segundo Nombre</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillEditarUsuario.cSegundoNombre" @keyup.enter="setEditarUsuario">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Apellido</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillEditarUsuario.cApellido" @keyup.enter="setEditarUsuario">
                                            </div>
                                        </div>
                                    </div>                                    

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Usuario</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillEditarUsuario.cUsuario" @keyup.enter="setEditarUsuario">
                                            </div>
                                        </div>
                                    </div>                                    

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Correo Electrónico</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillEditarUsuario.cCorreo" @keyup.enter="setEditarUsuario">
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
                                                    v-model="fillEditarUsuario.cContrasena"
                                                    @keyup.enter="setEditarUsuario"
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


                                    <!-- DESPLIEGA LOS ROLES DISPONIBLES -->
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Rol</label>
                                            <div class="col-md-9">
                                                <el-select 
                                                    v-model="fillEditarUsuario.nIdRol" 
                                                    placeholder="Seleccione uno Rol"
                                                    clearable
                                                >
                                                        <el-option
                                                            v-for="item in listRoles"
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
                                        @click.prevent="setEditarUsuario"
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
            fillEditarUsuario: {
                nIdUsuario     : this.$attrs.id,
                mIdRol         : '',
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
            },            
            // NEGOCIO
            form               : new FormData,
            fullscreenLoading  : false,
            listRoles          : [],

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
        compCNombreCompleto()
        {
            return fillVerUsuario.cPrimerNombre + ' ' + fillVerUsuario.cSegundoNombre + ' ' + fillVerUsuario.cApellido;
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
                //response = response.json()
                console.log("response: ::")
                console.log(response);
                this.fullscreenLoading = false;
                // datos usuario
                this.fillEditarUsuario.cPrimerNombre    =       response.data[0].firstname;
                this.fillEditarUsuario.cSegundoNombre   =       response.data[0].secondname;
                this.fillEditarUsuario.cApellido        =       response.data[0].lastname;
                this.fillEditarUsuario.cUsuario         =       response.data[0].username;
                this.fillEditarUsuario.cCorreo          =       response.data[0].email;
                this.fullscreenLoading                  =       false;
            })
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
                 .catch(error => {
                    console.log("error::::")
                    if (error.response.status == 401) {
                        this.$router.push({name: 'login'})
                        location.reload();
                        sessionStorage.clear();
                        this.fullscreenLoading = false;
                    }
                })
        },
        
        setGuardarUsuarioSinFotografia()
        {
            this.setGuardarUsuario(0)
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

            if ( !this.fillEditarUsuario.nIdRol ) {
                this.mensajeError.push('Debe seleccionar el Rol desde la lista desplegable')
            }            

            if (this.mensajeError.length) {
                this.error = 1
            }

            return this.error
        },

        getListarRoles() 
        {
            this.fullscreenLoading = true;
            var url = '/administracion/rol/getListarRoles'

            axios.get(url).then( response => {                                
                this.listRoles = response.data;
                this.fullscreenLoading = false;
            }).catch(error => {
                console.log(error)
            })
        },
        getRolByUsuario()
        {
            this.fullscreenLoading = true;
            var url = '/administracion/usuario/getRolByUsuario'

            axios.get(url, {
                params: {
                    'nIdUsuario'    :   this.fillEditarUsuario.nIdUsuario
                }
            }).then( response => {
                console.log(response.data)
                this.fillEditarUsuario.mIdRol  =  (response.data.length == 0) ? '' : response.data[0].nIdRol;
                this.fullscreenLoading = false;
            }).catch(error => {
                console.log(error)
            })            
        },

        setEditarRolByUsuario()
        {            
            var url = '/administracion/usuario/setEditarRolByUsuario'
            axios.put(url, {
                'nIdUsuario'        : this.fillEditarUsuario.nIdUsuario,
                'nIdRol'            : this.fillEditarUsuario.nIdRol,
            }).then( respuesta => {
                this.fullscreenLoading = false
                this.$router.push('/usuario')
            }).catch( error => console.log(error))            
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
                this.setEditarRolByUsuario();
                this.fullscreenLoading = false;   
                // position: 'top-end',
                
                Swal.fire({                    
                    icon: 'success',
                    title: 'Se actualizó el usuario correctamente',
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
    },

    mounted() {
        // al cargar el componente, obtener info. del usuario seleccionado
        // con base en el id Pasado.
        console.log("mounthed");
        this.getUsuarioById ();
        this.getListarRoles();

        this.getRolByUsuario();
    },    
}
</script>

<style>

</style>