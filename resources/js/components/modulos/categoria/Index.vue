<template>
<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Categoria</h1>
                </div><!-- /.col -->            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <template v-if="listCategorias.includes('categoria.crear')">
                        <router-link class="btn btn-info btn-sm" :to="{ name: 'categoria.crear' }">
                            <i class="fas fa-plus-square"></i>
                            Nueva Categoría
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
                                            <label class="col-md-3 col-form-label">Nombre</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillBusquedaCategoria.cNombre" @keyup.enter="getListarCategorias">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Descripción</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillBusquedaCategoria.cDescripcion" @keyup.enter="getListarCategorias">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Estado</label>
                                            <div class="col-md-9">
                                                <el-select 
                                                    v-model="fillBusquedaCategoria.cEstado" 
                                                    placeholder="Seleccione uno de los estados"
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
                                    </div>                                                                         -->
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-4 offset-4">
                                    <button 
                                        class="btn btn-flat btn-info btnWidth" 
                                        @click.prevent="getListarCategorias"
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
                            <template v-if="listarCategoriasPaginated.length">
                                <table class="table table-hover table-head-fixed text-nowrap projects">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Nombre</th>
                                            <th>Descripcion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in listarCategoriasPaginated" :key="index">
                                            <td v-text="item.name"></td>
                                            <td v-text="item.description"></td>
                                            <td>
                                                <template v-if="listCategorias.includes('categoria.editar')">
                                                    <router-link class="btn btn-flat btn-info btn-sm" :to="{ name: 'categoria.editar', params: { id: user.id }}">
                                                        <i class="fas fa-pencil-alt"></i> Editar.                                        
                                                    </router-link>
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
export default {
    data(){
        return {
            fillBusquedaCategoria: {
                cNombre  : '',
                cDescripcion : ''
            },
            fullscreenLoading: false,
            listCategorias: [],
            listRolPermisosByUsuario: JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario')),
            listEstados: [
                {value: 'A', label: 'Activo'},
                {value: 'B', label: 'Inactivo'},
            ],
            pageNumber: 0,
            perPage: 5
        }
    },
    computed: {
        pageCount() {
            // 20   => elementos en total
            // 5    => registros por página
            // 20/5 =  4
            let a = this.listCategorias.length,
                b = this.perPage

            // devolver en entero mayor
            return Math.ceil(a/b);
        },

        // Obtener registros paginados
        listarCategoriasPaginated() {
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
            return this.listCategorias.slice(inicio, fin);
        },

        pagesList() {
            let a = this.listCategorias.length,
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
            this.fillBusquedaCategoria.cNombre  =  '';
            this.fillBusquedaCategoria.cDescripcion =  '';
        },
        limpiarBandejaCategorias() {
            this.listCategorias = [];
        },
        getListarCategorias() 
        {
            this.fullscreenLoading = true;
            var url = '/configuracion/categoria/getListarCategorias'

            axios.get(url, {
                params: {
                    'cNombre'       :  this.fillBusquedaCategoria.cNombre,
                    'cDescripcion'  :  this.fillBusquedaCategoria.cDescripcion
                }
            }).then( response => {
                this.inicializarPaginacion();
                console.log(response.data);                
                this.listCategorias = response.data;
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
        }
    }   
}
</script>

<style>

</style>