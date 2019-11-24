// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from 'axios';
import Vuex from 'vuex'
import VModal from 'vue-js-modal'

Vue.use(Vuex)
Vue.use(VModal)

Vue.directive('focus', {
    inserted: function (el) {
        el.focus()
    }
})
axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';

Vue.config.productionTip = false
Vue.prototype.$http = axios
// Vue.prototype.$urlAPI = `http://${window.location.hostname}:8000/api/`
Vue.prototype.$urlAPI = `http://localhost:8000/api/`

var store = {
    state: {
        usuario: sessionStorage.getItem('usuario') ? JSON.parse(sessionStorage.getItem('usuario')) : null,
        data: {}
    },
    getters: {
        isAdmin: state => {
            return state.usuario.is_admin;
        },
        getUsuario: state => {
            return state.usuario;
        },
        getToken: state => {
            return state.usuario.token;
        },
        getData: state => {
            return state.data;
        }
    },
    mutations: {
        setUsuario(state, n) {
            state.usuario = n;
        },
        setData(state, data) {
            state.data = data;
        }
    }
};


/* eslint-disable no-new */
new Vue({
    el: '#app',
    store: new Vuex.Store(store),
    router,
    template: '<App/>',
    components: { App }
})
