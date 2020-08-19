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
        { path: '/permiso', component: require('./components/modulos/permiso/Index').default },
        { path: '/reporte', component: require('./components/modulos/reporte/Index').default },
    ],
    mode: 'history',
    linkActiveClass: 'active'
})      