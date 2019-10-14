import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/pages/home/Home'
import Login from '@/pages/login/Login'
import Perfil from '@/pages/perfil/Perfil'
import Cadastro from '@/pages/registro/Cadastro'

Vue.use(Router)

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/cadastro',
            name: 'Cadastro',
            component: Cadastro
        },
        {
            path: '/perfil',
            name: 'Perfil',
            component: Perfil
        }
    ]
})
