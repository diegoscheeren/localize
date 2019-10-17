<template>
    <site-template>
        <span slot="principal">
            <h1 class="center">Bem vindo, {{this.usuario.name}}!</h1>
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'
import CardDetalheVue from '@/components/localize/CardDetalheVue'
import CardConteudoVue from '@/components/localize/CardConteudoVue'

export default {
    name: 'Home',
    components: {
        SiteTemplate,
        CardDetalheVue,
        CardConteudoVue,
    },
    data () {
        return {
            usuario: false
        }
    },
    created() {
        let sessionUser = sessionStorage.getItem('usuario');
        if (sessionUser) {
            this.usuario = JSON.parse(sessionUser);
            this.name = this.usuario.name;
            this.email = this.usuario.email;
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
