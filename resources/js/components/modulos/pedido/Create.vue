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
                                            pedidos list: {{ listPedidos.length }}
                                            <button
                                                class="btn btn-flat btn-info btn-block"
                                                @click.prevent="setRegistrarPedido"
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
                                    <h3 class="card-title">Seleccionar Productos</h3>
                                </div>

                                <div class="card-body table-responsive">

                                    <vs-tooltip not-arrow right>
                                        <vs-button
                                            @click="agregarProducto"
                                            square
                                            icon
                                            color="rgb(59,222,200)"
                                            gradient
                                        >
                                            <i class="fas fa-plus-square"></i>
                                        </vs-button>
                                        <template #tooltip>
                                        Agregar Producto
                                        </template>
                                    </vs-tooltip>


                                    <template v-if="listPedidos.length">
                                        <div class="scrollTable">
                                            <table class="table table-hover table-head-fixed text-nowrap projects">
                                                <thead>
                                                    <tr>
                                                        <th>Artículo</th>
                                                        <th>Stock</th>
                                                        <th>Precio</th>
                                                        <th>SubTotal</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr
                                                        v-for="(item, index) in listPedidos"
                                                        :key="index"
                                                    >
                                                        <td>
                                                            <!-- Filterable: con base a lo escrito, vaya filtrando en el Selector -->
                                                            <el-select
                                                                @change="obtenerProducto(item.nIdProducto, index)"
                                                                v-model="item.nIdProducto"
                                                                placeholder="Seleccione una Producto"
                                                                clearable
                                                                filterable
                                                            >
                                                                    <el-option
                                                                        v-for="item in listProductos"
                                                                        :key="item.id"
                                                                        :label="item.name"
                                                                        :value="item.id"
                                                                    >
                                                                    </el-option>
                                                            </el-select>
                                                        </td>
                                                        <td>
                                                            <el-input-number
                                                                v-model="item.nStock"
                                                                :min="1"
                                                                :max="(item.nIdProducto) ? item.nStockFlag : 1"
                                                                controls-position="right"
                                                            >
                                                            </el-input-number>
                                                        </td>
                                                        <td v-text="item.fPrecio"></td>
                                                        <td>{{ item.fSubTotal = item.nStock * item.fPrecio }}</td>
                                                        <td>
                                                            <el-tooltip
                                                                class="item"
                                                                effect="dark"
                                                                content="Left Center prompts info"
                                                                placement="left"
                                                            >
                                                                <vs-button
                                                                    @click="removerProducto(index)"
                                                                    square
                                                                    icon
                                                                    danger
                                                                    gradient
                                                                >
                                                                    <i class="fas fa-trash"></i>
                                                                </vs-button>
                                                            </el-tooltip>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <el-row :gutter="20">
                                            <el-col :span="16">
                                                <vs-input border v-model="cComentario" placeholder="name" />
                                            </el-col>
                                            <el-col :span="8">
                                                <strong>Total:</strong> {{ fTotalPedido = totalPedido }}
                                            </el-col>
                                        </el-row>

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
import { mixinUtilidades } from "./../../../mixins/mixins";
export default {
    mixins: [mixinUtilidades],
    data(){
        return {
            links: [],
            cBusqueda: '',
            listRolPermisosByUsuario: [],
            listClientesFilter: [],

            cComentario: '',
            fTotalPedido: 0,


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
            listProductos       : [],
            listPedidos         : [],
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
        },

        totalPedido() {
            // return
            return this.listPedidos.reduce( function( valorAnterior, valorActual){
                console.log("valores: anteriorl " , valorAnterior, " , siguiente: ", valorActual)
                return valorAnterior + parseFloat(valorActual.fSubTotal)
            } ,0)
        },
    },
    methods: {

        /**
         *  ### SETTERS
        */

        setRegistrarPedido()
        {
            if (this.validarRegistrarPedido()) {
                this.modalShow = true;
                return;
            }

            this.fullscreenLoading = true;

            if (this.switchCliente || this.switchCliente == true) {
                this.setRegistrarCliente();
                return;
            } else {
                this.setGuardarPedido(this.fillCrearCliente.nIdCliente);
            }

            console.log("list permisos filter: ",this.listPermisosFilter)

            // var url = '/operacion/pedido/setRegistrarPedido'
            // axios.post(url, {
            //     'nIdCliente'            : this.fillCrearCliente.nIdCliente,
            //     'cComentario'           : this.cComentario,
            //     'fTotalPedido'          : this.fTotalPedido,
            //     'listPedido'            : this.listPedidos
            // }).then( respuesta => {
            //     this.fullscreenLoading = false;
            //     this.$router.push('/pedido')
            // }).catch(error => {
            //     console.log("error::::")
            //     // if (error.response.status == 401) {
            //     //     this.$router.push({name: 'login'})
            //     //     location.reload();
            //     //     sessionStorage.clear();
            //     //     this.fullscreenLoading = false;
            //     // }
            // });


            // var url = '/administracion/rol/setRegistrarPedido'
            // axios.post(url, {
            //     'cNombre'            : this.fillCrearCliente.cNombre,
            //     'cSlug'              : this.fillCrearCliente.cSlug,
            //     'listPermisosFilter' : this.listPermisosFilter
            // }).then( respuesta => {
            //     console.log("registro creado exitosamente")
            //     this.fullscreenLoading = false;
            //     this.$router.push('/rol');
            // }).catch(error => {
            //     console.log("error::::")
            //     if (error.response.status == 401) {
            //         this.$router.push({name: 'login'})
            //         location.reload();
            //         sessionStorage.clear();
            //         this.fullscreenLoading = false;
            //     }
            // })
        },

        /**
         * Registra a un cliente
         */
        setRegistrarCliente()
        {
            this.fullscreenLoading = true;
            var url = '/operacion/cliente/setRegistrarCliente'
            axios.post(url, {
                'cNombre'            : this.fillCrearCliente.cNombre,
                'cDocumento'         : this.fillCrearCliente.cDocumento,
                'cApellido'          : this.fillCrearCliente.cApellido,
                'cCorreo'            : this.fillCrearCliente.cCorreo,
                'cTelefono'          : this.fillCrearCliente.cTelefono
            }).then( respuesta => {
                console.log("### COMPONENTE CLIENTE - CREAR ", respuesta)
                let nIdCliente = response.data[0].nIdCliente;
                this.setGuardarPedido(nIdCliente);
                // this.getListarClientes();
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

        /**
         * Registra pedidos
         */
        setGuardarPedido(nIdCliente)
        {
            var url = '/operacion/pedido/setRegistrarPedido'
            axios.post(url, {
                'nIdCliente'            : nIdCliente,
                'cComentario'           : this.cComentario,
                'fTotalPedido'          : this.fTotalPedido,
                'listPedido'            : this.listPedidos
            }).then( respuesta => {
                console.log(respuesta.data, " res ");
                // Generar Doc
                // this.setGenerarDocumento(respuesta.data);

                // Enviar email
                this.setGenerarEmail(respuesta.data);
                // this.$router.push('/pedido');
            }).catch(error => {
                console.log("error::::", error)
                if (error.response && error.response.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    this.fullscreenLoading = false;
                }
            })
        },

        setGenerarEmail(nIdPedido)
        {
            // this.activarLoaderCustom();
            this.fullscreenLoading = true;
            var url = '/operacion/pedido/setGenerarEmail';
            console.log("nIdPedido::: ", nIdPedido)
            // Configurando data-type
            var config = {
                responseType: 'blob'
            };

            axios.post(url, {
                'nIdPedido': nIdPedido
            }, config)
            .then( response => {
                console.log(response.data);
                this.setGenerarDocumento(nIdPedido)
                this.fullscreenLoading = false;
                // this.pausarLoaderCustom();
            }).catch(error => {
                console.log("error ::: ", error);
                if (error.response && error.response.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    // this.pausarLoaderCustom();
                }
            });
        },

        // FUNCIONALIDADES EXTRA : VER PDF
        setGenerarDocumento(nIdPedido) {
            //
            this.activarLoaderCustom();
            var url = '/operacion/pedido/setGenerarDocumento';

            console.log("nIdPedido::: ", nIdPedido)

            // Configurando data-type
            var config = {
                responseType: 'blob'
            };

            axios.post(url, {
                'nIdPedido'       :   nIdPedido
            }, config)
            .then( response => {
                console.log(response.data);
                // Formatear respuesta a Blob - Javascript
                var blobPdf = new Blob([response.data], {type: 'application/pdf'}); // the blob

                // Renderizamos el Blob:
                var url = URL.createObjectURL(blobPdf);
                window.open(url);

                this.pausarLoaderCustom();
            }).catch(error => {
                if (error.response && error.response.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    this.pausarLoaderCustom();
                }
            });
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

        // marcarFila(index)
        // {
        //     this.listPermisosFilter[index].checked     =    !this.listPermisosFilter[index].checked;
        // },

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


        /**
         *  ### GETTERS
        */

        // LISTAR PRODUCTOS
        getListarProductos()
        {
            //var ruta = '/administracion/usuario/getListarClientes'
            var ruta = '/configuracion/producto/getListarProductos';
            axios.get(ruta).then( response => {
                console.log("### Cliente - component - listProductos: response.data: ", response)
                this.listProductos = response.data;
                // this.filterListarClientes();
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

        // Refactorizado
        getListarClientes()
        {
            //var ruta = '/administracion/usuario/getListarClientes'
            var ruta = '/operacion/cliente/getListarClientes';
            axios.get(ruta).then( response => {
                console.log("### Cliente - component - inicial: response.data: ", response)
                this.listClientes = response.data;
                this.filterListarClientes();
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
        },

        // OPERACIONES CON PRODUCTOS Y PEDIDOS
        agregarProducto()
        {
            let me = this;

            if (this.listPedidos.length == 0) {
                this.listPedidos.push({
                    'nIdArticulo'   :   '',
                    'nStock'        :   '',
                    'nStockFlag'    :   '',
                    'fPrecio'       :   '',
                    'fSubTotal'     :   '',
                });
            }
            else
            {
                let contador = 0;
                this.listPedidos.map( function(x, y) {
                    if (!x.nIdProducto || !x.nStock || !x.fPrecio || !x.fSubTotal) {
                        contador ++;
                        // NOFICACIONES
                        const noti = me.$vs.notification({
                            square: true,
                            color: 'rgb(59,222,200)',
                            position: 'bottom-right',
                            title: 'Alerta',
                            text: 'Debe completar la información de la fila: ' + (y+1)
                        })
                    }
                })

                if (contador == 0) {
                    this.listPedidos.push({
                        'nIdArticulo'   :   '',
                        'nStock'        :   '',
                        'nStockFlag'    :   '',
                        'fPrecio'       :   '',
                        'fSubTotal'     :   '',
                    });
                }
            }

        },

        obtenerProducto(nIdProducto, index)
        {
            let me = this;
            let contador = 0;

            // reestablecer el resto de cols a cero cuando NO hay producto seleccionado
            if (!nIdProducto) {
                Vue.nextTick(function(){
                    me.listPedidos[index].nStockFlag  =   '';
                    me.listPedidos[index].nStock      =   '';
                    me.listPedidos[index].fPrecio     =   '';
                })
            }

            this.listPedidos.map( function(x, y) {
                if (x.nIdProducto == nIdProducto && y != index) {
                    contador ++;
                    // NOFICACIONES
                    const noti = me.$vs.notification({
                        square: true,
                        color: 'rgb(59,222,200)',
                        position: 'bottom-right',
                        title: 'Alerta',
                        text: 'El Producto ya se encuentra en la fila: ' + (y+1)
                    });
                }
            })

            if (contador == 0) {

                // FILTRANDO COINCIDENCIAS
                let rpta = this.listProductos.filter(producto => {
                    return ((String(producto.id)).indexOf(String(nIdProducto)) != -1);
                });

                if (rpta[0].stock > 0) {
                    this.listPedidos[index].nStockFlag = rpta[0].stock;
                    this.listPedidos[index].nStock   =   rpta[0].stock;
                    this.listPedidos[index].fPrecio  =   rpta[0].price;
                } else {
                    this.listPedidos[index].nIdProducto  =   '';
                    // NOTIFICACION :::
                    const noti = me.$vs.notification({
                        square: true,
                        color: 'rgb(59,222,200)',
                        position: 'bottom-right',
                        title: 'Alerta',
                        text: 'El Producto seleccionado no cuenta con Stock disponible'
                    });
                }
            }
        },

        removerProducto(index) {
            this.$delete(this.listPedidos, index);
        },

    },
    mounted(){
        this.agregarProducto();
        this.getListarClientes();
        this.getListarProductos();
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

    /* VUESAX COMPONENTE  - TOOLTIP */
    .vs-tooltip-content {
        width: min-content;
    }


    /* EKEMENT - UI - LAYOUT */
    .el-row {
        margin-bottom: 20px;
    }

    .el-row:last-child {
        margin-bottom: 0;
    }

    .el-col {
        border-radius: 4px;
    }
    .bg-purple-dark {
        background: #99a9bf;
    }
    .bg-purple {
        background: #d3dce6;
    }
    .bg-purple-light {
        background: #e5e9f2;
    }
    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }
    .row-bg {
        padding: 10px 0;
        background-color: #f9fafc;
    }
</style>
