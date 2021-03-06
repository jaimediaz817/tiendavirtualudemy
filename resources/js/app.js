/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// TODO: componentes

/**
 * ELEMENT - UI - biblioteca para interfaz de usuario
 */
//import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
// Importando el idioma de Element:
import locale from 'element-ui/lib/locale/lang/en'

// TODO: para usarse globalmente anteponemos el nodo window:
// Fixed:
// #1 se agrega el idioma de elemento UI por defecto
window.Vue.use(ElementUI, { locale });



/**
 * Vuesax - biblioteca para interfaz de usuario
 */
import Vuesax from 'vuesax'
import 'vuesax/dist/vuesax.css' //Vuesax styles
Vue.use(Vuesax, {
  // options here
})




// TODO: sweet alert2
import Swal from 'sweetalert2'
window.Swal = Swal;



// TODO: agregar EventBus - comunicación entre componentes
export const EventBus = new Vue();
window.EventBus = EventBus;


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


// TODO: add sound library - reproducir audio desde el lado del FRONT
import Howler from 'howler';
window.Howler = Howler;

// TODO: add moment
import moment from 'moment';
moment.locale('es');
window.moment = moment;

Vue.component('App', require('./components/App.vue').default);

// TODO: -jid- registrando un nuevo componente:
Vue.component('Auth', require('./components/Auth.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// TODO: add: importando el ruteador
import router from './routes'

const app = new Vue({
    el: '#app',
    router
});
