<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Crear Rol</h1>
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
                                    <h3 class="card-title">Formulario Registrar Rol</h3>
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
                                                            v-model="fillCrearRol.cNombre"
                                                            @keyup.enter="setRegistrarRolPermisos"
                                                        >
                                                        </el-input>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="col-md-3 col-form-label">Url Amigable</label>
                                                    <div class="col-md-9">
                                                        <el-input
                                                            placeholder="Ingrese la url amigable"
                                                            clearable
                                                            v-model="fillCrearRol.cSlug"
                                                            @keyup.enter="setRegistrarRolPermisos"
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
                                                @click.prevent="setRegistrarRolPermisos"
                                                v-loading.fullscreen.lock="fullscreenLoading"
                                            >Registrar</button>
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
            fillCrearRol: {
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
        }
    },
    computed: {

    },
    methods: {
        setRegistrarRolPermisos()
        {
            if (this.validarRegistrarRolPermisos()) {
                this.modalShow = true;
                return;                
            }

            this.fullscreenLoading = true;

            console.log("list permisos filter: ",this.listPermisosFilter)

            var url = '/administracion/rol/setRegistrarRolPermisos'
            axios.post(url, {
                'cNombre'            : this.fillCrearRol.cNombre,
                'cSlug'              : this.fillCrearRol.cSlug,
                'listPermisosFilter' : this.listPermisosFilter
            }).then( respuesta => {
                console.log("registro creado exitosamente")
                this.fullscreenLoading = false;
                this.$router.push('/rol');
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
            this.fillCrearRol.cNombre     = ''
            this.fillCrearRol.cSlug    = ''
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

            if ( !this.fillCrearRol.cNombre ) {
                this.mensajeError.push('El nombre es un campo obligatorio')
            }

            if ( !this.fillCrearRol.cSlug ) {
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
            axios.get(ruta).then( response => {
                this.listPermisos = response.data;
                this.filterPermisosByRol();
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

        filterPermisosByRol()
        {
            var me = this;
            me.listPermisos.map( function(x, y){
                me.listPermisosFilter.push({
                    'id'     : x.id,
                    'name'   : x.name,
                    'slug'   : x.slug,
                    'checked': false
                })
            });
        },

        marcarFila(index)
        {
            this.listPermisosFilter[index].checked     =    !this.listPermisosFilter[index].checked;
        }
    },
    mounted(){
        this.getListarPermisosByRol()
    },
}
</script>

<style>

</style>