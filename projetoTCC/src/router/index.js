import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/pages/home/Home'
import Login from '@/pages/login/Login'
import Item from '@/pages/cadastro/Item'
import Perfil from '@/pages/perfil/Perfil'
import Pedido from '@/pages/cadastro/Pedido'
import Cliente from '@/pages/cadastro/Cliente'
import Registro from '@/pages/registro/Registro'
import PesquisaItem from '@/pages/pesquisa/Item'
import ItemGrupo from '@/pages/cadastro/ItemGrupo'
import PesquisaPedido from '@/pages/pesquisa/Pedido'
import PesquisaCliente from '@/pages/pesquisa/Cliente'
import UnidadeMedida from '@/pages/cadastro/UnidadeMedida'
import PesquisaItemGrupo from '@/pages/pesquisa/ItemGrupo'
import PesquisaUnidadeMedida from '@/pages/pesquisa/UnidadeMedida'

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
            path: '/pesquisa/cliente',
            name: 'PesquisaCliente',
            component: PesquisaCliente
        },
        {
            path: '/pesquisa/item',
            name: 'PesquisaItem',
            component: PesquisaItem
        },
        {
            path: '/pesquisa/pedido',
            name: 'PesquisaPedido',
            component: PesquisaPedido
        },
        {
            path: '/cadastro/pedido',
            name: 'Pedido',
            component: Pedido
        },
        {
            path: '/pesquisa/unidade-medida',
            name: 'PesquisaUnidadeMedida',
            component: PesquisaUnidadeMedida
        },
        {
            path: '/cadastro/unidade-medida',
            name: 'UnidadeMedida',
            component: UnidadeMedida
        },
        {
            path: '/pesquisa/grupo',
            name: 'PesquisaItemGrupo',
            component: PesquisaItemGrupo
        },
        {
            path: '/cadastro/grupo',
            name: 'ItemGrupo',
            component: ItemGrupo
        },
        {
            path: '*',
            redirect: '/'
        }
    ]
})
