import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    routes: [
        { path: '/', component: require('./components/modulos/dahsboard/Index').default },
        { path: '/pedido', component: require('./components/modulos/pedido/Index').default },
        { path: '/cliente', component: require('./components/modulos/cliente/Index').default },
        { path: '/categoria', component: require('./components/modulos/categoria/Index').default },

        { path: '/producto', component: require('./components/modulos/producto/Index').default },
        { path: '/usuario', component: require('./components/modulos/usuario/Index').default },
        { path: '/usuario/crear', component: require('./components/modulos/usuario/create').default },
        { 
            path: '/usuario/editar/:id', 
            name: 'usuario.editar',
            component: require('./components/modulos/usuario/Edit').default,
            props: true,
        },
        { 
            path: '/usuario/ver/:id', 
            name: 'usuario.ver',
            component: require('./components/modulos/usuario/View').default,
            props: true,
        },

        { path: '/rol', component: require('./components/modulos/rol/Index').default },
        { path: '/rol/crear', component: require('./components/modulos/rol/Create').default },
        { 
            path: '/rol/editar/:id', 
            name: 'rol.editar',
            component: require('./components/modulos/rol/Edit').default,
            props: true,
        },        

        { path: '/permiso', component: require('./components/modulos/permiso/Index').default },
        { path: '/permiso/crear', component: require('./components/modulos/permiso/Create').default },
        { 
            path: '/permiso/editar/:id', 
            name: 'permiso.editar',
            component: require('./components/modulos/permiso/Edit').default,
            props: true,
        },

        { path: '/reporte', component: require('./components/modulos/reporte/Index').default },
    ],
    mode: 'history',
    linkActiveClass: 'active'
})      