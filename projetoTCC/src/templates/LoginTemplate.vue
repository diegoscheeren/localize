<template>
  <span>
    <header>
        <nav-bar class="nav-wrapper grey darken-4">
            <li v-if="!usuario"><router-link to="/login">Entrar</router-link></li>
            <li v-if="usuario"><router-link to="/perfil">{{usuario.name}}</router-link></li>
            <li v-if="usuario"><a v-on:click="sair()">Sair</a></li>
        </nav-bar>
    </header>
    <main>
        <div class="container center">
            <slot name="principal" />
        </div>
    </main>

  </span>
</template>

<script>
import NavBar from '@/components/layouts/NavBar'
import CardMenuVue from '@/components/layouts/CardMenuVue'

export default {
    name: 'LoginTemplate',
    data() {
        return {
            usuario: false
        }
    },
    components:{
        NavBar,
        CardMenuVue
    },
    created() {
        let usuarioAux = this.$store.getters.getUsuario;
        if (usuarioAux) {
            this.usuario = this.$store.getters.getUsuario;
            this.$router.push('/');
        }
    }
}
</script>

<style>
</style>
