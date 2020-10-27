<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Editar Rol</h1>
                </div><!-- /.col -->            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <router-link class="btn btn-info btn-sm" :to="'/rol'">
                        <i class="fas fa-arrow-left"></i>
                        Regresar
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Formulario Editar Rol</h3>
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
                                                            v-model="fillEditarRol.cNombre"
                                                            @keyup.enter="setEditarRolPermisos"
                                                        >
                                                        </el-input>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-3 col-form-label">Url Amigable</label>
                                                    <div class="col-md-9">
                                                        <!-- BOTON EDITAR -->
                                                        <el-input
                                                            placeholder="Ingrese la url amigable"
                                                            clearable
                                                            v-model="fillEditarRol.cSlug"
                                                            @keyup.enter="setEditarRolPermisos"                                                            
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
                                            <button 
                                                class="btn btn-flat btn-info btnWidth" 
                                                @click.prevent="setEditarRolPermisos"
                                                v-loading.fullscreen.lock="fullscreenLoading"
                                            >Editar</button>
                                            <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarFormulario">Limpiar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Listar Permisos</h3>
                                </div>

                                <div class="card-body table-responsive">
                                    <template v-if="listPermisosFilter.length">
                                        <div class="scrollTable">
                                            <table class="table table-hover table-head-fixed text-nowrap projects">
                                                <thead>
                                                    <tr>
                                                        <th>Accion</th>                                                    
                                                        <th>Nombre</th>
                                                        <th>Url amigable</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr 
                                                        v-for="(item, index) in listPermisosFilter" 
                                                        :key="index"
                                                        @click.prevent="marcarFila(index)"
                                                    >
                                                        <td>
                                                            <!-- Irá acá el checkbox para selecionar los permisos que se le asignan al rol -->
                                                            <el-checkbox v-model="item.checked"></el-checkbox>
                                                        </td>
                                                        <td v-text="item.name"></td>
                                                        <td v-text="item.slug"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>                                    
                                    </template>
                                    <template v-else>
                                        <div class="callout callout-info">
                                            <h5>No se encontraron resultados...</h5>
                                        </div>
                                    </template>

                                    <div class="card-footer">
       
                                    </div>
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
            fillEditarRol: {
                nIdRol: this.$attrs.id,
                cNombre  : '',
                cSlug : '',
            },
            listPermisos: [],
            fullscreenLoading: false,
            listPermisosFilter: [],

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

            listRolPermisosByUsuario: [],
            listRolPermisosByUsuarioFilter: [],
        }
    },
    computed: {

    },
    methods: {
        setEditarRolPermisos()
        {
            if (this.validarRegistrarRolPermisos()) {
                this.modalShow = true;
                return;                
            }

            this.fullscreenLoading = true;
        

            var url = '/administracion/rol/setEditarRolPermisos'
            axios.post(url, {
                'nIdRol'             : this.fillEditarRol.nIdRol,
                'cNombre'            : this.fillEditarRol.cNombre,
                'cSlug'              : this.fillEditarRol.cSlug,
                'listPermisosFilter' : this.listPermisosFilter
            }).then( respuesta => {
                console.log("registro creado exitosamente");
                this.getListarRolPermisosByUsuario();                  
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
            this.fillEditarRol.cNombre     = ''
            this.fillEditarRol.cSlug    = ''
        },

        // MODAL
        abrirModal ()
        {
            this.modalShow = !this.modalShow;
        },

        // VALIDACIONES
        validarRegistrarRolPermisos ()
        {
            this.error = 0
            this.mensajeError = []

            if ( !this.fillEditarRol.cNombre ) {
                this.mensajeError.push('El nombre es un campo obligatorio')
            }

            if ( !this.fillEditarRol.cSlug ) {
                this.mensajeError.push('La URL amigable es un campo obligatorio')
            }            

            // VLIDAR QUE EXISTA POR LO MENOS UN PERMISO SELECCIONADO
            let contador = 0;
            this.listPermisosFilter.map((x, y) => {
                if (x.checked == true) {
                    contador ++;
                }
            })

            if (contador == 0) {
                this.mensajeError.push("Debe seleccionar por lo menos un permiso desde la lista");
            }

            if (this.mensajeError.length) {
                this.error = 1
            }

            return this.error
        },

        getListarPermisosByRol()        
        {
            var ruta = '/administracion/rol/getListarPermisosByRol'
            axios.get(ruta, {
                params: {
                    'nIdRol':   this.fillEditarRol.nIdRol
                }
            }).then( response => {
                console.log(":::::::::::::::::: data permissions By Role: ::::::::::::::::: ", this.listPermisos)
                this.listPermisos = response.data;
                this.filterPermisosByRol();                
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

        filterPermisosByRol()
        {
            var me = this;
            me.listPermisos.map( function(x, y){
                me.listPermisosFilter.push({
                    'id'     : x.id,
                    'name'   : x.name,
                    'slug'   : x.slug,
                    'checked': (x.checked == 1) ? true : false
                })
            });

            console.log("permisos ya filtrados (2) :::  ", me.listPermisos);
        },

        marcarFila(index)
        {
            this.listPermisosFilter[index].checked     =    !this.listPermisosFilter[index].checked;
            console.log("### CLICK ### ", this.listPermisosFilter);
            console.log("....................................................");
        },

        getListarRoles() 
        {
            this.fullscreenLoading = true;
            var url = '/administracion/rol/getListarRoles'

            axios.get(url, {
                params: {
                    'nIdRol'    :   this.fillEditarRol.nIdRol
                }
            }).then( response => {
                console.log("response data roles:")
                console.log(response.data);
                this.fillEditarRol.cNombre  =   response.data[0].name;
                this.fillEditarRol.cSlug    =   response.data[0].slug;
                this.fullscreenLoading      =   false;
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

        // Traido desde el componente de Login.vue
        getListarRolPermisosByUsuario()        
        {
            var ruta = '/administracion/usuario/getListarRolPermisosByUsuario'
            axios.get(ruta).then( response => {
                this.listRolPermisosByUsuario = [];
                this.listRolPermisosByUsuario = response.data;
                this.filterListarRolPermisosByUsuario();
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

        filterListarRolPermisosByUsuario()
        {
            var me = this;
            me.listRolPermisosByUsuarioFilter = [];
            me.listRolPermisosByUsuario.map( function(x, y){
                me.listRolPermisosByUsuarioFilter.push(x.slug)
            });

            sessionStorage.removeItem('listRolPermisosByUsuario');
            sessionStorage.clear();
            sessionStorage.setItem('listRolPermisosByUsuario', 
                JSON.stringify(me.listRolPermisosByUsuarioFilter)
            );

            // TODO: event-emit
            console.log("emitiendo evento: ",  me.listRolPermisosByUsuarioFilter.length)
            EventBus.$emit('notifyRolPermisosByUsuario', me.listRolPermisosByUsuarioFilter);
            this.fullscreenLoading = false;

            Swal.fire({                    
                icon: 'success',
                title: 'Se actualizó correctamente los roles y permisos',
                showConfirmButton: false,
                timer: 1500
            })                 
        },         
    },
    mounted()
    {
        this.getListarRoles();
        this.getListarPermisosByRol();
        // this.getListarRolPermisosByUsuario(); 
    },
}
</script>

<style>

</style>