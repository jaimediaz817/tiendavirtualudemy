<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Pedido</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <template v-if="listRolPermisosByUsuario.includes('pedido.crear')">
                        <router-link class="btn btn-info btn-sm" :to="{ name: 'pedido.crear' }">
                            <i class="fas fa-plus-square"></i>
                            Nuevo Pedido
                        </router-link>
                    </template>
                </div>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Criterios de Búsqueda</h3>
                        </div>
                        <div class="card-body">
                            <form role="form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">#Documento</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillBusquedaPedido.cNombre" @keyup.enter="getListarPedidos">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">#Pedido</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillBusquedaPedido.cNombre" @keyup.enter="getListarPedidos">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Descripción</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillBusquedaPedido.cDescripcion" @keyup.enter="getListarPedidos">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Estado</label>
                                            <div class="col-md-9">
                                                <el-select
                                                    v-model="fillBusquedaPedido.cEstado"
                                                    placeholder="Seleccione una Estado"
                                                    clearable
                                                >
                                                        <el-option
                                                            v-for="item in listEstados"
                                                            :key="item.value"
                                                            :label="item.label"
                                                            :value="item.value"
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
                                        @click.prevent="getListarPedidos"
                                        v-loading.fullscreen.lock="fullscreenLoading"
                                    >Buscar</button>
                                    <button class="btn btn-flat btn-default btnWidth" @click.prevent="limpiarCriteriosBusqueda">Limpiar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resultados -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Bandeja de resultados</h3>
                        </div>
                        <div class="card-body table-responsive">
                            <template v-if="listarPedidosPaginated.length">
                                <table class="table table-hover table-head-fixed text-nowrap projects">
                                    <thead>
                                        <tr>
                                            <th>#Pedido</th>
                                            <th>#Documento</th>
                                            <th>Cliente</th>
                                            <th>Total</th>
                                            <th>Vendedor</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in listarPedidosPaginated" :key="index">
                                            <td v-text="item.pedido"></td>
                                            <td v-text="item.documento"></td>
                                            <td v-text="item.cliente"></td>
                                            <td v-text="item.total"></td>
                                            <td v-text="item.vendedor"></td>
                                            <td>
                                                <span v-if="item.state == 'A'" class="badge badge-success" v-text="item.estado"></span>
                                                <span v-else class="badge badge-danger" v-text="item.estado"></span>
                                            </td>
                                            <!-- <td v-text="item.estado"></td> -->
                                            <td>
                                                <template v-if="listRolPermisosByUsuario.includes('pedido.ver')">
                                                    <!-- Boton para desactivar estado -->
                                                    <button class="btn btn-flat btn-info btn-sm" @click.prevent="setGenerarDocumento(item.pedido)">
                                                        <i class="far fa-file-pdf"></i> Ver PDF
                                                    </button>
                                                    <!-- <router-link class="btn btn-flat btn-info btn-sm" :to="{ name: 'pedido.ver', params: { id: item.id }}">
                                                        <i class="far fa-file-pdf"></i> Ver PDF
                                                    </router-link> -->
                                                </template>

                                                <template v-if="listRolPermisosByUsuario.includes('pedido.rechazar')">
                                                    <!-- Boton para desactivar estado -->
                                                    <button v-if="item.state == 'A'" class="btn btn-flat btn-danger btn-sm" @click.prevent="setCambiarEstadoPedido(1, item.id)">
                                                        <i class="fas fa-trash"></i> Rechazar
                                                    </button>
                                                </template>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </template>
                            <template v-else>
                                <div class="callout callout-info">
                                    <h5>No se encontraron resultados...</h5>
                                </div>
                            </template>
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-right">
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
                                </ul>
                            </div>
                        </div>
                    </div>
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
            fillBusquedaPedido: {
                cNombre  : '',
                cDocumento : '',
                cPedido : '',
                cEstado: ''
            },
            fullscreenLoading: false,
            listPedidos: [],
            listEstados: [
                {value: 'A', label: 'Activo'},
                {value: 'I', label: 'Inactivo'},
            ],
            listRolPermisosByUsuario: JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')),
            pageNumber: 0,
            perPage: 5
        }
    },
    computed: {
        pageCount() {
            // 20   => elementos en total
            // 5    => registros por página
            // 20/5 =  4
            let a = this.listPedidos.length,
                b = this.perPage

            // devolver en entero mayor
            return Math.ceil(a/b);
        },

        // Obtener registros paginados
        listarPedidosPaginated() {
            // PAGINA 1
            // 0 * 5= 0
            // 0 + 5 = 5
            // 0 - (5-1)

            // PAGINA 2
            // 1 * 5 = 5
            // 5 + 5 = 10
            // 5 - (5-1)

            // PAGINA 3
            // 2 * 5 = 10
            // 10 + 5 = 15
            // 10 - (15-1)
            let inicio = this.pageNumber *  this.perPage,
                fin    = inicio + this.perPage;

            console.log("inicio y fin: ", inicio, " , ", fin)
            return this.listPedidos.slice(inicio, fin);
        },

        pagesList() {
            let a = this.listPedidos.length,
                b = this.perPage
            let pageCount  = Math.ceil( a/b );
            let count      = 0,
                pagesArray = [];

            /**
             * 0 < 4 => 0
             * 1 < 4 => 0, 1
             * 2 < 4 => 0, 1, 2
             * 3 < 4 => 0, 1, 2, 3
             * 4 < 4 => 0, 1, 2, 3
             */
            while (count < pageCount) {
                pagesArray.push(count);
                count ++;
            }

            return pagesArray;
        }
    },
    methods: {
        limpiarCriteriosBusqueda() {
            this.fillBusquedaPedido.cNombre     =  '';
            this.fillBusquedaPedido.cDocumento  =  '';
            this.fillBusquedaPedido.cPedido     =  '';
            this.fillBusquedaPedido.cEstado   =  '';
        },

        limpiarBandejaCategorias() {
            this.listPedidos = [];
        },

        // Listar los Productos del sistema con su info de Stock
        getListarPedidos()
        {
            this.fullscreenLoading = true;
            var url = '/operacion/pedido/getListarPedidos'

            axios.get(url, {
                params: {
                    'cNombre'       :   this.fillBusquedaPedido.cNombre,
                    'cDocumento'    :   this.fillBusquedaPedido.cDocumento,
                    'cPedido'       :   this.fillBusquedaPedido.cPedido,
                    'cEstado'     :     this.fillBusquedaPedido.cEstado
                }
            }).then( response => {
                this.inicializarPaginacion();
                this.listPedidos = response.data;
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

        inicializarPaginacion() {
            this.pageNumber = 0;
        },

        // funcionalidad propia
        nextPage() {
            this.pageNumber ++;
        },
        prevPage() {
            this.pageNumber --;
        },
        selectCurrentPage(page) {
            this.pageNumber = page;
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
                if (error.response.status == 401) {
                    this.$router.push({name: 'login'})
                    location.reload();
                    sessionStorage.clear();
                    this.pausarLoaderCustom();
                }
            });
        },

        // Rechazar pedido:
        setCambiarEstadoPedido(estado, idpedido)
        {
            // text: "You won't be able to revert this!",
            Swal.fire({
                title: '¿Está seguro de ' + ((estado == 1) ? 'rechazar' : 'activar') + ' el pedido?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: ((estado == 1) ? 'Si, Rechazar' : 'Si, activar'),
                cancelButtonText: 'Cancelar operación'
            }).then((result) => {
                if (result.value) {
                    // TODO: petición al servidor
                    this.fullscreenLoading = true;
                    var url = '/operacion/pedido/setCambiarEstadoPedido'
                    axios.post(url, {
                        'nIdPedido': idpedido,
                        'cEstado'   : (estado == 1) ? 'I' : 'A'
                    }).then( response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Se ' + ((estado == 1) ? 'desativo' : 'activo') + ' el usuario',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getListarPedidos();
                    }).catch(error => {
                        console.log("error::::")
                        if (error.response.status == 401) {
                            this.$router.push({name: 'login'})
                            location.reload();
                            sessionStorage.clear();
                            this.fullscreenLoading = false;
                        }
                    })
                }
            })
        },
    },
    mounted() {
        this.getListarPedidos();
        console.log("mixins: ", this.activarLoaderCustom())

        this.pausarLoaderCustom();
    }
}
</script>

<style>

</style>
