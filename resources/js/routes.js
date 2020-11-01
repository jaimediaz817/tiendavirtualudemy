import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

// Funciones propias
function verificarAcceso(to, from, next) {
    // console.log("### ROUTES - ", JSON.parse(sessionStorage.getItem('authUser')))
    let authUser = JSON.parse(sessionStorage.getItem('authUser'));

    if (authUser) {
        console.info("el usuario se encuentra autenticado");
        // Obteniendo los permisos:
        let listRolPermisosByUsuario = JSON.parse(sessionStorage.getItem('listRolPermisosByUsuario'));

        if (listRolPermisosByUsuario.includes(to.name)) {
            next();
        } else {
            let listRolPermisosByUsuarioFilter = [];

            listRolPermisosByUsuario.map( function(x) {
                if (x.includes('index')) {
                    listRolPermisosByUsuarioFilter.push(x);
                }
            });

            if (to.name == 'dashboard.index') {
                next({ name: listRolPermisosByUsuarioFilter[0]});                
            } else {
                next(from.path);
            }
            
        }
    }
    else 
    {
        next('/login');
    }
}

export const rutas = [
    { 
        path: '/login', 
        name: 'login',
        component: require('./components/modulos/authenticate/Login').default,            
        beforeEnter: (to, from, next) => {
            let authUser = JSON.parse(sessionStorage.getItem('authUser'));
            if (authUser) {
                next({ name: 'dashboard.index' });
            }
            else {
                next();
            }            
        }        
    },

    { 
        path: '/', 
        name: 'dashboard.index',
        component: require('./components/modulos/dahsboard/Index').default,  
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }
    },  

    { 
        path: '/pedido', 
        name: 'pedido.index',
        component: require('./components/modulos/pedido/index').default,    
        beforeEnter: (to, from, next) => {                
            verificarAcceso(to, from, next);
        }
    },  

    // { 
    //     path: '/categoria', 
    //     name: 'categoria.index',
    //     component: require('./components/modulos/categoria/index').default,            
    // },  

    // { 
    //     path: '/producto', 
    //     name: 'producto.index',
    //     component: require('./components/modulos/producto/index').default,            
    // },  

    // { 
    //     path: '/usuario', 
    //     name: 'usuario.Index',
    //     component: require('./components/modulos/usuario/Index').default,            
    // },  

    // { 
    //     path: '/usuario/crear', 
    //     name: 'producto.crear',
    //     component: require('./components/modulos/usuario/create').default,            
    // },  

    // { 
    //     path: '/usuario/editar', 
    //     name: 'producto.editar',
    //     component: require('./components/modulos/usuario/Edit').default,            
    // },  

    // { 
    //     path: '/usuario/ver/:id', 
    //     name: 'producto.ver',
    //     component: require('./components/modulos/usuario/View').default,            
    // },  

    // { 
    //     path: '/usuario/permiso/:id', 
    //     name: 'producto.permiso',
    //     component: require('./components/modulos/usuario/Permission').default,            
    // },  

    // { 
    //     path: '/rol', 
    //     name: 'rol.index',
    //     component: require('./components/modulos/rol/Index').default,            
    // },  

    // { 
    //     path: '/rol/crear', 
    //     name: 'rol.crear',
    //     component: require('./components/modulos/rol/Create').default,            
    // },  

    // { 
    //     path: '/rol/editar/:id', 
    //     name: 'rol.editar',
    //     component: require('./components/modulos/rol/Edit').default,            
    // },  

    // { 
    //     path: '/permiso/crear', 
    //     name: 'permiso.crear',
    //     component: require('./components/modulos/permiso/Create').default,            
    // },  

    // { 
    //     path: '/permiso/editar/:id', 
    //     name: 'permiso.editar',
    //     component: require('./components/modulos/permiso/Edit').default,            
    // },
    
    // { 
    //     path: '/reporte', 
    //     name: 'reporte.index',
    //     component: require('./components/modulos/reporte/Index').default,            
    // },  


    // { path: '/', component: require('./components/modulos/dahsboard/Index').default },
    // { path: '/pedido', component: require('./components/modulos/pedido/Index').default },
    { 
        path: '/cliente', 
        name: 'cliente.index',
        component: require('./components/modulos/cliente/Index').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },
    { 
        path: '/categoria', 
        name: 'categoria.index',
        component: require('./components/modulos/categoria/Index').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },

    { 
        path: '/categoria/crear', 
        name: 'categoria.crear',
        component: require('./components/modulos/categoria/Create').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },

    { 
        path: '/categoria/editar/:id', 
        name: 'categoria.editar',
        component: require('./components/modulos/categoria/Edit').default,
        props: true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },    

    { 
        path: '/producto', 
        name: 'producto.index',
        component: require('./components/modulos/producto/Index').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },

    { 
        path: '/producto/crear', 
        name: 'producto.crear',
        component: require('./components/modulos/producto/Create').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },    

    { 
        path: '/producto/editar/:id', 
        name: 'producto.editar',
        component: require('./components/modulos/producto/Edit').default,
        props: true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },      

    { 
        path: '/usuario', 
        name: 'usuario.index',
        component: require('./components/modulos/usuario/Index').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },

    { 
        path: '/usuario/crear', 
        name: 'usuario.crear',
        component: require('./components/modulos/usuario/create').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },

    { 
        path: '/usuario/editar/:id', 
        name: 'usuario.editar',
        component: require('./components/modulos/usuario/Edit').default,
        props: true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },

    { 
        path: '/usuario/ver/:id', 
        name: 'usuario.ver',
        component: require('./components/modulos/usuario/View').default,
        props: true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },

    { 
        path: '/usuario/permiso/:id', 
        name: 'usuario.permiso',
        component: require('./components/modulos/usuario/Permission').default,
        props: true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },



    { 
        path: '/rol', 
        name: 'rol.index',
        component: require('./components/modulos/rol/Index').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },

    { 
        path: '/rol/crear', 
        name: 'rol.crear',
        component: require('./components/modulos/rol/Create').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },

    { 
        path: '/rol/editar/:id', 
        name: 'rol.editar',
        component: require('./components/modulos/rol/Edit').default,
        props: true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },        

    { 
        path: '/permiso', 
        name: 'permiso.index',
        component: require('./components/modulos/permiso/Index').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },

    { 
        path: '/permiso/crear', 
        name: 'permiso.crear',
        component: require('./components/modulos/permiso/Create').default 
    },
    
    { 
        path: '/permiso/editar/:id', 
        name: 'permiso.editar',
        component: require('./components/modulos/permiso/Edit').default,
        props: true,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },

    { 
        path: '/reporte', 
        name: 'reporte.pedido.index',
        component: require('./components/modulos/reporte/Index').default,
        beforeEnter: (to, from, next) => {
            verificarAcceso(to, from, next);
        }            
    },      

    { 
        path: '*', 
        component: require('./components/plantilla/404').default        
    },       
];

export default new Router({
    routes: rutas,
    mode: 'history',
    linkActiveClass: 'active'
})      