<template>
    <span>
        <header style="position: fixed; top: 0; width: 100%; z-index: 1;">
            <nav-bar :user="usuario" logo="Localize" url="/" cor="grey darken-4">
                <li v-if="!usuario"><router-link to="/login">Entrar</router-link></li>
                <li class="hide-on-small-only" v-if="usuario">
                    <router-link to="/perfil">{{usuario.name}}</router-link>
                </li>
                <li v-if="usuario" :title="usuario.name">
                    <router-link class="hide-on-med-and-up" to="/perfil">
                        <i class="material-icons">account_circle</i>
                    </router-link>
                </li>
                <li v-if="usuario"><a v-on:click="sair()">Sair</a></li>
            </nav-bar>
        </header>

        <side-nav-vue/>
        <main style="padding-top: 60px;" @click="closeSideNav">
            <div class="container">
                <div class="row">
                    <slot name="principal"/>
                </div>
            </div>
        </main>
    </span>
</template>

<script>
import NavBar from '@/components/layouts/NavBar'
import SideNavVue from '@/components/layouts/SideNavVue'
import CardMenuVue from '@/components/layouts/CardMenuVue'

export default {
    name: 'SiteTemplate',
    data() {
        return {
            usuario: false
        }
    },
    components: {
        NavBar,
        SideNavVue,
        CardMenuVue
    },
    created() {
        let usuarioAux = this.$store.getters.getUsuario;
        if (usuarioAux) {
            this.usuario = this.$store.getters.getUsuario;
        } else {
            this.$router.push('/login');
        }
    },
    methods: {
         closeSideNav() {
            $('.sidenav').sidenav('close');
        },
        sair() {
            this.$store.commit('setUsuario', null);
            sessionStorage.clear();
            this.usuario = false;
            this.$router.push('/login');
        }
    }
}
</script>

<style>

</style>
