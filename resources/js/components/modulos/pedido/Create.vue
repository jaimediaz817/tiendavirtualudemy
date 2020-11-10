<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Crear Pedido</h1>
                </div><!-- /.col -->            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <router-link class="btn btn-info btn-sm" :to="'/pedido'">
                        <i class="fas fa-arrow-left"></i>
                        Regresar
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card" :class="(switchCliente) ? 'card-info' : 'card-success'">
                                <div class="card-header">
                                    <h3 class="card-title">{{ (switchCliente) ? 'Formulario Registrar Cliente' : 'Buscar' }}</h3>
                                </div>
                                <div class="card-body">
                                    <form role="form">                                        
                                        <div class="row">

                                            <div class="col-md-3">
                                                <vs-switch v-model="switchCliente" @change="limpiarCriterios">
                                                    <template #off>
                                                        <i class="fas fa-plus-square"></i>
                                                    </template>
                                                    <template #on>
                                                        <i class="fas fa-search"></i>
                                                    </template>
                                                </vs-switch>
                                            </div>

                                            <div class="col-md-12">
                                                <!-- campos -->
                                                <div class="form-group row">
                                                    <label class="col-md-12 col-form-label">Documento</label>
                                                    <div class="col-md-12">
                                                        <template v-if="switchCliente">
                                                            <el-input
                                                                placeholder="Ingrese el #Documento"
                                                                clearable
                                                                v-model="fillCrearCliente.cDocumento"
                                                                @keyup.enter="setRegistrarCliente"
                                                            >
                                                            </el-input>
                                                        </template>
                                                        <template v-else>
                                                            <el-autocomplete                
                                                                popper-class="inline-input"
                                                                v-model="cBusqueda"
                                                                :fetch-suggestions="querySearch"
                                                                placeholder="Buscar..."
                                                                :trigger-on-focus="true"
                                                                @select="handleClienteSelect"
                                                                size="medium"                
                                                            >
                                                                <i
                                                                    class="el-icon-search el-input__icon"
                                                                    slot="suffix">
                                                                </i>              
                                                            </el-autocomplete>  
                                                        </template>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-12 col-form-label">Nombre</label>
                                                    <div class="col-md-12">
                                                        <el-input
                                                            placeholder="Ingrese el Nombre"
                                                            clearable
                                                            v-model="fillCrearCliente.cNombre"
                                                            @keyup.enter="setRegistrarCliente"
                                                        >
                                                        </el-input>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-12 col-form-label">Apellido</label>
                                                    <div class="col-md-12">
                                                        <el-input
                                                            placeholder="Ingrese el Apellido"
                                                            clearable
                                                            v-model="fillCrearCliente.cApellido"
                                                            @keyup.enter="setRegistrarCliente"
                                                        >
                                                        </el-input>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-12 col-form-label">Email</label>
                                                    <div class="col-md-12">
                                                        <vs-input 
                                                            v-model="fillCrearCliente.cCorreo" 
                                                            placeholder="correo@gmail.com"
                                                            :disabled="(switchCliente) ? false : true"
                                                        >
                                                            <template 
                                                                v-if="validEmail" 
                                                                #message-success                                                                
                                                            >Correo electrónico válido</template>
                                                            <template 
                                                                v-if="!validEmail && fillCrearCliente.cCorreo !== ''" 
                                                                #message-danger
                                                            >El correo electrónico no tiene el formato correcto</template>
                                                        </vs-input>                                                        
                                                        <el-input
                                                            type="email"
                                                            placeholder="Ingrese el Correo Electrónico"
                                                            clearable
                                                            v-model="fillCrearCliente.cCorreo"
                                                            @keyup.enter="setRegistrarCliente"
                                                        >
                                                        </el-input>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-12 col-form-label">Teléfono</label>
                                                    <div class="col-md-12">
                                                        <el-input
                                                            type="tel"
                                                            placeholder="Ingrese el Teléfono"
                                                            clearable
                                                            v-model="fillCrearCliente.cTelefono"
                                                            @keyup.enter="setRegistrarCliente"
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
                                                class="btn btn-flat btn-info btn-block" 
                                                @click.prevent="setRegistrarCliente"
                                                v-loading.fullscreen.lock="fullscreenLoading"
                                            >Registrar</button>
                                            <!-- <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarFormulario">Limpiar</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
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
            links: [],
            cBusqueda: '',            
            listRolPermisosByUsuario: [],
            listClientesFilter: [],
            
        
            fillCrearCliente: {
                nIdCliente  : '',                
                cDocumento  : '',
                cNombre  : '',
                cApellido   : '',
                cTelefono   : '',
                cCorreo     : '',
            },
            switchCliente       : false,
            listClientes        : [],
            listPermisos        : [],
            fullscreenLoading   : false,
            listPermisosFilter  : [],

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
            return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.fillCrearCliente.cCorreo)
        }
    },
    methods: {
        setRegistrarPedido(){

            if (this.switchCliente) {
                this.setRegistrarCliente();
            }

            if (this.validarRegistrarPedido()) {
                this.modalShow = true;
                return;                
            }

            this.fullscreenLoading = true;

            console.log("list permisos filter: ",this.listPermisosFilter)

            var url = '/administracion/rol/setRegistrarPedido'
            axios.post(url, {
                'cNombre'            : this.fillCrearCliente.cNombre,
                'cSlug'              : this.fillCrearCliente.cSlug,
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

        /**
         * Registra a un cliente
         */
        setRegistrarCliente()
        {
            var url = '/operacion/cliente/setRegistrarCliente'
            axios.post(url, {
                'cNombre'            : this.fillCrearCliente.cNombre,
                'cDocumento'         : this.fillCrearCliente.cDocumento,
                'cApellido'          : this.fillCrearCliente.cApellido,
                'cCorreo'            : this.fillCrearCliente.cCorreo,
                'cTelefono'          : this.fillCrearCliente.cTelefono
            }).then( respuesta => {
                console.log("### COMPONENTE CLIENTE - CREAR ", respuesta)
                this.fullscreenLoading = false;
                this.getListarClientes();
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
            this.fillCrearCliente.cNombre     = ''
            this.fillCrearCliente.cSlug    = ''
        },

        // MODAL
        abrirModal ()
        {
            this.modalShow = !this.modalShow;
        },

        // VALIDACIONES
        validarRegistrarPedido ()
        {
            this.error = 0
            this.mensajeError = []

            if (this.switchCliente)
            {
                if ( !this.fillCrearCliente.cDocumento ) {
                    this.mensajeError.push('El Documento es un campo obligatorio')
                }   
                                
                if ( !this.fillCrearCliente.cNombre ) {
                    this.mensajeError.push('El Nombre es un campo obligatorio')
                }

                if ( !this.fillCrearCliente.cApellido ) {
                    this.mensajeError.push('El Apellido es un campo obligatorio')
                }                

                if (this.fillCrearCliente.cCorreo) {
                    if (!this.validEmail) {
                        this.mensajeError.push('El Correo electrónico no tiene un formato correcto')
                    }
                }
            }
            else {
                if (!this.fillCrearCliente.nIdCliente) {
                    this.mensajeError.push("El Cliente es necesario cargar")
                }
            }

            // VLIDAR QUE EXISTA POR LO MENOS UN PERMISO SELECCIONADO
            // let contador = 0;
            // this.listPermisosFilter.map((x, y) => {
            //     if (x.checked == true) {
            //         contador ++;
            //     }
            // })
            // if (contador == 0) {
            //     this.mensajeError.push("Debe seleccionar por lo menos un permiso desde la lista");
            // }

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
        },

        // AUTOCOMPLETE
        querySearch(queryString, cb) {
            console.log("### EVENT ::: querySearch, ", queryString)
            var links = this.listClientesFilter;
            var results = queryString ? links.filter(this.createFilter(queryString)) : links;
            // call callback function to return suggestions
            cb(results);
        },
        createFilter(queryString) {
            return (link) => {
                //   return (link.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0);
                return (link.value.toLowerCase().indexOf(queryString.toLowerCase()) != -1);
            };
        },    
        handleClienteSelect(item) {
            let clienteSeleccionado = this.listClientes.filter(cliente => {
                return ( (String(cliente.id)).indexOf(String(item.link)) != -1);
            });

            console.log("### CLIENTE SELECCIONADO : ", clienteSeleccionado);
            this.fillCrearCliente.nIdCliente    =   clienteSeleccionado[0].id;
            this.fillCrearCliente.cDocumento    =   clienteSeleccionado[0].document;
            this.fillCrearCliente.cNombre       =   clienteSeleccionado[0].name;
            this.fillCrearCliente.cApellido     =   clienteSeleccionado[0].lastname;
            this.fillCrearCliente.cCorreo       =   clienteSeleccionado[0].email;
            this.fillCrearCliente.cTelefono     =   clienteSeleccionado[0].phone; 
        },            

        // Refactorizado
        getListarClientes()
        {
            //var ruta = '/administracion/usuario/getListarClientes'
            var ruta = '/operacion/cliente/getListarClientes';
            axios.get(ruta).then( response => {
                console.log("### Cliente - component - inicial: response.data: ", response)
                this.listClientes = response.data;
                this.filterListarClientes();
            });
        },        

    
        filterListarClientes()
        {            
            var me = this;
            me.listClientesFilter = [];

            me.listClientes.map( function(x, y){
                console.log(".")
                // if (this.list.includes('index')) {
                     me.listClientesFilter.push({
                         'value':  x.document + ' - ' + x.fullname,
                         'link' :  x.id
                     });
                // }
            });
        },   

        limpiarCriterios() 
        {
            this.cBusqueda                      =   '';
            this.fillCrearCliente.nIdCliente    =   '';
            this.fillCrearCliente.cDocumento    =   '';
            this.fillCrearCliente.cNombre       =   '';
            this.fillCrearCliente.cApellido     =   '';
            this.fillCrearCliente.cCorreo       =   '';
            this.fillCrearCliente.cTelefono     =   '';
        }

    },
    mounted(){
        this.getListarPermisosByRol();
        this.getListarClientes();
    },
}
</script>

<style>
    /* ELEMENT UI */
    .col-md-12 div.el-autocomplete {
        width: 100%;
    }
    /* VUESAX COMPONENTE */
    input#vs-input--28 {
        width: 100%;
    }    
</style>