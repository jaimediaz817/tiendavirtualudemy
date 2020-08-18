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
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <router-link class="btn btn-info btn-sm" :to="'/usuario/crear'">
                        <i class="fas fa-plus-square"></i>
                        Nuevo Usuario
                    </router-link>
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
                                                <input type="text" class="form-control" v-model="fillBusquedaUsuario.cNombre" @keyup.enter="getListarUsuarios">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Usuario</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" v-model="fillBusquedaUsuario.cUsuario" @keyup.enter="getListarUsuarios">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Correo Electrónico</label>
                                            <div class="col-md-9">
                                                <input type="email" class="form-control" v-model="fillBusquedaUsuario.cCorreo" @keyup.enter="getListarUsuarios">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Estado</label>
                                            <div class="col-md-9">
                                                <el-select 
                                                    v-model="fillBusquedaUsuario.cEstado" 
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
                                    </div>                                                                        
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-4 offset-4">
                                    <button 
                                        class="btn btn-flat btn-info btnWidth" 
                                        @click.prevent="getListarUsuarios"
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
                            <template v-if="listarUsuariosPaginated.length">
                                <table class="table table-hover table-head-fixed text-nowrap projects">
                                    <thead>
                                        <tr>
                                            <th>Fotografía</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Usuario</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(user, index) in listarUsuariosPaginated" :key="index">
                                            <td>
                                                <template v-if="!user.profile_image">
                                                    <li class="user-block li-item-clearLi">
                                                        <img 
                                                            src="/img/avatar.png" 
                                                            alt="user.username" 
                                                            class="profile-avatar-img img-fluid img-circle"
                                                        />
                                                    </li>
                                                </template>
                                                <template v-else>
                                                    <li class="user-block li-item-clearLi">
                                                        <img 
                                                            :src="user.profile_image" 
                                                            :alt="user.username" 
                                                            class="profile-avatar-img img-fluid img-circle"
                                                        />
                                                    </li>
                                                </template>
                                            </td>
                                            <td v-text="user.fullname"></td>
                                            <td v-text="user.email"></td>
                                            <td v-text="user.username"></td>
                                            <td>
                                                <template v-if="user.state == 'A'">
                                                    <span class="badge badge-success" v-text="user.state_alias"></span>    
                                                </template>
                                                <template v-else>
                                                    <span class="badge badge-danger" v-text="user.state_alias"></span>
                                                </template>                                            
                                            </td>
                                            <td>
                                                <router-link class="btn btn-flat btn-primary btn-sm" :to="'/'">
                                                    <i class="fas fa-folder"></i> Ver                                                
                                                </router-link>

                                                <template v-if="user.state == 'A'">
                                                    <router-link class="btn btn-flat btn-info btn-sm" :to="{ name: 'usuario.editar', params: { id: user.id }}">
                                                        <i class="fas fa-pencil-alt"></i> Editar.                                        
                                                    </router-link>
                                                    <router-link class="btn btn-flat btn-success btn-sm" :to="'/'">
                                                        <i class="fas fa-key"></i> Permiso                                                
                                                    </router-link>
                                                    <button
                                                        class="btn btn-flat btn-danger btn-sm"
                                                        @click.prevent="setCambiarEstadoUsuario(1, user.id)"
                                                    >
                                                        <i class="fas fa-trash"></i> Desactivar                                                
                                                    </button>
                                                </template>
                                                <template v-else>
                                                    <button 
                                                        class="btn btn-flat btn-primary btn-sm"
                                                        @click.prevent="setCambiarEstadoUsuario(2, user.id)"
                                                    >
                                                        <i class="fas fa-folder"></i> Activar                                                
                                                    </button>
                                                    <!-- <router-link class="btn btn-flat btn-success btn-sm" :to="'/'">
                                                        <i class="fas fa-check"></i> Ver                                                
                                                    </router-link> -->
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
            fillBusquedaUsuario: {
                cNombre  : '',
                cUsuario : '',
                cCorreo  : '',
                cEstado  : '',
            },
            fullscreenLoading: false,
            listUsuarios: [],
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
            let a = this.listUsuarios.length,
                b = this.perPage

            // devolver en entero mayor
            return Math.ceil(a/b);
        },

        // Obtener registros paginados
        listarUsuariosPaginated() {
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
            return this.listUsuarios.slice(inicio, fin);
        },

        pagesList() {
            let a = this.listUsuarios.length,
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
            this.fillBusquedaUsuario.cNombre  =  '';
            this.fillBusquedaUsuario.cUsuario =  '';
            this.fillBusquedaUsuario.cCorreo  =  '';
            this.fillBusquedaUsuario.cEstado  =  '';
        },
        limpiarBandejaUsuarios() {
            this.listUsuarios = [];
        },
        getListarUsuarios() 
        {
            this.fullscreenLoading = true;
            var url = '/administracion/usuario/getListarUsuarios'

            axios.get(url, {
                params: {
                    'nIdUsuario':  this.fillBusquedaUsuario.nIdUsuario,
                    'cNombre'   :  this.fillBusquedaUsuario.cNombre,
                    'cUsuario'  :  this.fillBusquedaUsuario.cUsuario,
                    'cCorreo'   :  this.fillBusquedaUsuario.cCorreo,
                    'cEstado'   :  this.fillBusquedaUsuario.cEstado,
                }
            }).then( response => {
                this.inicializarPaginacion();
                console.log(response.data);                
                this.listUsuarios = response.data;
                this.fullscreenLoading = false;
            }).catch(error => {
                console.log("error::::")
                console.log(error)
            })
        },

        setCambiarEstadoUsuario(estado, idUsuario)
        {
            // text: "You won't be able to revert this!",
            Swal.fire({
                title: '¿Está seguro de ' + ((estado == 1) ? 'desactivar' : 'activar') + ' el usuario?',                
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: ((estado == 1) ? 'Si, desactivar' : 'Si, activar'),
                cancelButtonText: 'Cancelar operación'
            }).then((result) => {
                console.log("result :: ", result)
                if (result.value) {
                    // TODO: petición al servidor 
                    this.fullscreenLoading = true;
                    var url = '/administracion/usuario/setCambiarEstadoUsuario'
                    axios.post(url, {
                        'nIdUsuario': idUsuario,
                        'cEstado'   : (estado == 1) ? 'I' : 'A'
                    }).then( response => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Se ' + ((estado == 1) ? 'desativo' : 'activo') + ' el usuario',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        this.getListarUsuarios();
                    })
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