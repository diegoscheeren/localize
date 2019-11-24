import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/pages/home/Home'
import Login from '@/pages/login/Login'
import Item from '@/pages/cadastro/Item'
import Perfil from '@/pages/perfil/Perfil'
import Pedido from '@/pages/cadastro/Pedido'
import Usuario from '@/pages/cadastro/Usuario'
import Cliente from '@/pages/cadastro/Cliente'
import Finalizar from '@/pages/venda/Finalizar'
import PesquisaItem from '@/pages/pesquisa/Item'
import ItemGrupo from '@/pages/cadastro/ItemGrupo'
import PesquisaEstoque from '@/pages/estoque/Item'
import PesquisaComanda from '@/pages/venda/Comanda'
import PesquisaPedido from '@/pages/pesquisa/Pedido'
import PesquisaUsuario from '@/pages/pesquisa/Usuario'
import PesquisaCliente from '@/pages/pesquisa/Cliente'
import AcertoEstoque from '@/pages/estoque/AcertoEstoque'
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
            path: '/perfil',
            name: 'Perfil',
            component: Perfil
        },
        {
            path: '/cadastro-item',
            name: 'Cadastro',
            component: Item
        },
        {
            path: '/cadastro-cliente',
            name: 'Cliente',
            component: Cliente
        },
        {
            path: '/pesquisa-cliente',
            name: 'PesquisaCliente',
            component: PesquisaCliente
        },
        {
            path: '/pesquisa-item',
            name: 'PesquisaItem',
            component: PesquisaItem
        },
        {
            path: '/pesquisa-pedido',
            name: 'PesquisaPedido',
            component: PesquisaPedido
        },
        {
            path: '/cadastro-pedido',
            name: 'Pedido',
            component: Pedido
        },
        {
            path: '/pesquisa-unidade-medida',
            name: 'PesquisaUnidadeMedida',
            component: PesquisaUnidadeMedida
        },
        {
            path: '/cadastro-unidade-medida',
            name: 'UnidadeMedida',
            component: UnidadeMedida
        },
        {
            path: '/pesquisa-grupo',
            name: 'PesquisaItemGrupo',
            component: PesquisaItemGrupo
        },
        {
            path: '/cadastro-grupo',
            name: 'ItemGrupo',
            component: ItemGrupo
        },
        {
            path: '/pesquisa-usuario',
            name: 'PesquisaUsuario',
            component: PesquisaUsuario
        },
        {
            path: '/cadastro-usuario',
            name: 'Usuario',
            component: Usuario
        },
        {
            path: '/venda-comanda',
            name: 'Comanda',
            component: PesquisaComanda
        },
        {
            path: '/venda-finalizar',
            name: 'Finalizar',
            component: Finalizar
        },
        {
            path: '/pesquisa-estoque',
            name: 'PesquisaEstoque',
            component: PesquisaEstoque
        },
        {
            path: '/estoque-acerto',
            name: 'AcertoEstoque',
            component: AcertoEstoque
        },
        {
            path: '*',
            redirect: '/'
        }
    ]
})
