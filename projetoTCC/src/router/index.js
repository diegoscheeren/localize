import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/pages/home/Home'
import Login from '@/pages/login/Login'
import Item from '@/pages/cadastro/Item'
import Perfil from '@/pages/perfil/Perfil'
import Cliente from '@/pages/cadastro/Cliente'
import Registro from '@/pages/registro/Registro'
import PesquisaItem from '@/pages/pesquisa/Item'

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
            path: '/registro',
            name: 'Registro',
            component: Registro
        },
        {
            path: '/perfil',
            name: 'Perfil',
            component: Perfil
        },
        {
            path: '/cadastro/item',
            name: 'Cadastro',
            component: Item
        },
        {
            path: '/cadastro/cliente',
            name: 'Cliente',
            component: Cliente
        },
        {
            path: '/pesquisa/item',
            name: 'PesquisaItem',
            component: PesquisaItem
        },
        {
            path: '*',
            redirect: '/'
        }
    ]
})
