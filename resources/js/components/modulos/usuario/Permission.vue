<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Listar Permisos del Rol {{ fillPermiso.cNombreRol }}</h1>
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
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Formulario Registrar Rol</h3>
                                </div>
                                <div class="card-body">
  
                                      <template v-if="listPermisosByRolAsignado.length">
                                        <div class="scrollTable">
                                            <table class="table table-hover table-head-fixed text-nowrap projects">
                                                <thead>
                                                    <tr>                                               
                                                        <th>Nombre</th>
                                                        <th>Url amigable</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr 
                                                        v-for="(item, index) in listPermisosByRolAsignado" 
                                                        :key="index"
                                                        @click.prevent="marcarFila(index)"
                                                    >
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
                                                        <th>Acción</th>                                       
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
                                    <div class="card-footer clearfix">
                                        <!-- <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item" v-if="pageNumber > 0">
                                                <a href="#" class="page-link" @click.prevent="prevPage">Ant</a>
                                            </li>
                                            <li 
                                                class="page-item" 
                                                v-for="(page, index) in pagesList" :key="index" 
                                                @click.prevent="selectCurrentPage(page)"
                                                :class="[page == pageNumber ? 'active' : '']"
                                            >
                                                <a href="#" class="page-link">{{ page + 1 }}</a>
                                            </li>
                                            <li class="page-item" v-if="pageNumber < pageCount - 1">
                                                <a href="#" class="page-link" @click.prevent="nextPage">Sig</a>
                                            </li>
                                        </ul> -->
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-md-4 offset-4">
                        <button 
                            class="btn btn-flat btn-info btnWidth" 
                            @click.prevent="setRegistrarPermisosByUsuario"
                            v-loading.fullscreen.lock="fullscreenLoading"
                        >
                        Registrar
                        </button>
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
            fillPermiso: {
                nIdUsuario: this.$attrs.id,
                cNombreRol  : '',
            },
            listPermisosByRolAsignado: [],
            listPermisos: [],
            listPermisosFilter: [],
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

            // TRAIDOS DESDE LOGIN
            listRolPermisosByUsuario: [],
            listRolPermisosByUsuarioFilter: [],
        }
    },
    computed: {

    },
    methods: {
        getListarPermisosByRolAsignado ()        
        {
            var ruta = '/administracion/usuario/getListarPermisosByRolAsignado'
            axios.get(ruta, {
                params: {
                    'nIdUsuario': this.fillPermiso.nIdUsuario
                }
            }).then( response => {
                this.listPermisosByRolAsignado = response.data;
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

        getListarPermisosByUsuario()        
        {
            var ruta = '/administracion/usuario/getListarPermisosByUsuario'
            axios.get(ruta, {
                params: {
                    'nIdUsuario': this.fillPermiso.nIdUsuario
                }
            }).then( response => {
                console.log("### Permission - component - inicial: response.data: ", response)
                this.listPermisos = [];
                this.listPermisos = response.data;
                this.filterPermisosByUsuario();
                console.log("data permissions By Role: ", this.listPermisos)
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

        // setRegistrarRolPermisos
        //setRegistrarPermisosByUsuario
        setRegistrarPermisosByUsuario()
        {
            if (this.validarRegistrarPermisosByUsuario()) {
                this.modalShow = true;
                return;                
            }

            this.fullscreenLoading = true;
            console.log("list permisos filter: ",this.listPermisosFilter);
            var url = '/administracion/usuario/setRegistrarPermisosByUsuario';

            axios.post(url, {
                'nIdUsuario'            : this.fillPermiso.nIdUsuario,
                'listPermisosFilter'    : this.listPermisosFilter
            }).then( respuesta => {
                this.getListarRolPermisosByUsuario(true);
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
            this.fillPermiso.cNombre     = ''
            this.fillPermiso.cSlug    = ''
        },

        // MODAL
        abrirModal ()
        {
            this.modalShow = !this.modalShow;
        },

        // VALIDACIONES
        validarRegistrarPermisosByUsuario ()
        {
            this.error = 0
            this.mensajeError = []        

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

        filterPermisosByUsuario()
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
        },
// acticlav@bancolombia.com.co
// activación de clave principal 18402120
// 

        marcarFila(index)
        {
            this.listPermisosFilter[index].checked     =    !this.listPermisosFilter[index].checked;
        },


        getRolByUsuario()
        {
            this.fullscreenLoading = true;
            var url = '/administracion/usuario/getRolByUsuario'

            axios.get(url, {
                params: {
                    'nIdUsuario'    :   this.fillPermiso.nIdUsuario
                }
            }).then( response => {                
                //this.fillPermiso.nIdRol  =  (response.data.length == 0) ? '' : response.data[0].nIdRol;
                console.log("resp metodo refactorizado: ", response.data)
                this.fillPermiso.cNombreRol = (response.data.length == 0) ? '' : response.data[0].name;
                this.fullscreenLoading = false;
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
        getListarRolPermisosByUsuario(mostrarAlerta = true)        
        {
            //getListarPermisosByUsuario  
            // var ruta = '/administracion/usuario/getListarRolPermisosByUsuario';
            var ruta = '/administracion/usuario/getListarPermisosByUsuario';

            axios.get(ruta).then( response => {
                console.log("### Permission - component - inicial: response.data: PERMISOS", response.data)
                this.listRolPermisosByUsuario = response.data;
                this.filterListarRolPermisosByUsuario(mostrarAlerta);
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

        filterListarRolPermisosByUsuario(mostrarAlerta)
        {
            var me = this;
            me.listRolPermisosByUsuarioFilter = [];

            me.listRolPermisosByUsuario.map( function(x, y){
                if (x.checked == 1 || x.checked == true) {
                    me.listRolPermisosByUsuarioFilter.push(x.slug)
                }
            });

            sessionStorage.removeItem('listRolPermisosByUsuario');
            sessionStorage.setItem('listRolPermisosByUsuario', 
                JSON.stringify(me.listRolPermisosByUsuarioFilter)
            );

            // TODO: event-emit
            EventBus.$emit('notifyRolPermisosByUsuario', me.listRolPermisosByUsuarioFilter);
            console.log("registro creado exitosamente")
            this.fullscreenLoading = false;

            if (mostrarAlerta) {
                Swal.fire({                    
                    icon: 'success',
                    title: 'Se otorgaron los permisos al usuario correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });   
            }
        },       
    },

    // MONTADO
    mounted()
    {
        this.getListarPermisosByRolAsignado();
        this.getRolByUsuario();
        this.getListarPermisosByUsuario();
        this.getListarRolPermisosByUsuario(false);
    },
}
</script>

<style>

</style>