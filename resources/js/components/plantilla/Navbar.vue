<template>
	  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
		<!-- Left navbar links -->
		<ul class="navbar-nav">
		  <li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>

        <template v-if="listPermisos.includes('dashboard.index')">
            <li class="nav-item d-none d-sm-inline-block">
                <router-link class="nav-link" :to="{ name: 'dashboard.index' }" >
                    Inicio
                </router-link>
            </li>
        </template>

        <template v-if="listPermisos.includes('pedido.index')">
            <li class="nav-item d-none d-sm-inline-block">
                <router-link class="nav-link" :to="{ name: 'pedido.index' }" >
                    Pedido
                </router-link>
            </li>
        </template>
	</ul>

	<!-- SEARCH FORM -->
	<form class="form-inline ml-3">
		<div class="input-group input-group-sm">
            <!-- class="inline-input" -->
            <el-autocomplete                
                popper-class="my-autocomplete"
                v-model="cBusqueda"
                :fetch-suggestions="querySearch"
                placeholder="Buscar..."
                :trigger-on-focus="true"
                @select="handleSelect"
                size="small"                
            >
                <i
                    class="el-icon-search el-input__icon"
                    slot="suffix">
                </i>              
            </el-autocomplete>     
			<!-- <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search"> -->
            <!-- <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div> -->
		</div>
	</form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img 
                            :src="ruta + '/img/avatar.png'" 
                            alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                <!-- Message Start -->
                <div class="media">
                    <img 
                        :src="ruta + '/img/avatar.png'"
                        alt="User Avatar" class="img-size-50 img-circle mr-3"
                    >
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
        </div>
    <!-- Message End -->
    </a>


    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item">
        <!-- Message Start -->
        <div class="media">
            <img 
                :src="ruta + '/img/avatar.png'" 
                alt="User Avatar" class="img-size-50 img-circle mr-3"
            >
            <div class="media-body">
                <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
        </div>
        <!-- Message End -->
    </a>

    <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
    </div>
    </li>
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
    </a>
    </li>
    </ul>
    </nav>
</template>

<script>
export default {
    props: ['ruta', 'usuario', 'listPermisos'],
    data() {
        return {
            links: [],
            cBusqueda: '',
            listRolPermisosByUsuario: [],
            listRolPermisosByUsuarioFilter: [],
        }
    },

    methods: {
      querySearch(queryString, cb) {
        var links = this.listRolPermisosByUsuarioFilter;
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

      // TODO: DECARTAR!!
      loadAll() {
        return [
          { "value": "vue", "link": "https://github.com/vuejs/vue" },
          { "value": "element", "link": "https://github.com/ElemeFE/element" },
          { "value": "cooking", "link": "https://github.com/ElemeFE/cooking" },
          { "value": "mint-ui", "link": "https://github.com/ElemeFE/mint-ui" },
          { "value": "vuex", "link": "https://github.com/vuejs/vuex" },
          { "value": "vue-router", "link": "https://github.com/vuejs/vue-router" },
          { "value": "babel", "link": "https://github.com/babel/babel" }
         ];
      },

        handleSelect(item) {
            if (this.$route.name != item.link) {
                this.$router.push({name: item.link})
                this.cBusqueda = ''
            }
            else
            {
                this.cBusqueda = ''
            }
        },

        // Refactorizado
        getListarRolPermisosByUsuario()
        {
            //var ruta = '/administracion/usuario/getListarRolPermisosByUsuario'
            var ruta = '/administracion/usuario/getListarPermisosByUsuario';
            axios.get(ruta, {
                params: {
                    'nIdUsuario': this.usuario.id
                }
            }).then( response => {
                console.log("### Login - component - inicial: response.data: ", response)
                this.listRolPermisosByUsuario = response.data;
                this.filterListarRolPermisosByUsuario();
            })
        },        

    
        filterListarRolPermisosByUsuario()
        {            
            var me = this;
            me.listRolPermisosByUsuarioFilter = [];

            me.listRolPermisosByUsuario.map( function(x, y){
                if (x.slug.includes('index')) {
                     me.listRolPermisosByUsuarioFilter.push({
                         'value'    :   x.name,
                         'link'     :   x.slug
                     });
                }
                // me.listRolPermisosByUsuarioFilter.push(x.slug);
                
            });
        },            

    },

    mounted() 
    {
        EventBus.$on('notifyRolPermisosByUsuario', data => {
            console.log("actualizando la data from APP:: ", data.length);
            this.listRolPermisosByUsuario = [];
            this.listRolPermisosByUsuario = data;                
        });

        // this.links = this.loadAll();
        this.getListarRolPermisosByUsuario();
    },
}
</script>

<style>
  .my-autocomplete li {
      line-height: normal;
      padding: 7px;
  }      
  .my-autocomplete li .value{
        text-overflow: ellipsis;
        overflow: hidden;      
  }
  .my-autocomplete li .link{
        font-size: 12px;
        color: #b4b4b4;
  }
</style>