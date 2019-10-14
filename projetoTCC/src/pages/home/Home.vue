<template>
    <site-template>

        <span slot="menuesquerdo">
            <div class="row valign-wrapper">
                <grid-vue tamanho="4">
                    <img :src="usuario.imagem" :alt="usuario.name"
                        class="circle responsive-img">
                </grid-vue>
                <grid-vue tamanho="8">
                    <span class="black-text">
                        <h5>{{usuario.name}}</h5>
                    </span>
                </grid-vue>
            </div>
        </span>

        <span slot="principal">
            <publicar-conteudo-vue/>
            <card-conteudo-vue
                perfil="https://materializecss.com/images/yuna.jpg"
                nome="Diego"
                data="01/01/2019 12:30">

                <card-detalhe-vue
                    img="https://materializecss.com/images/sample-1.jpg"
                    titulo="Main publication"
                    txt="txt exemplo">
                </card-detalhe-vue>

            </card-conteudo-vue>
        </span>

    </site-template>
</template>

<script>
import GridVue from '@/components/layouts/GridVue'
import SiteTemplate from '@/templates/SiteTemplate'
import CardDetalheVue from '@/components/localize/CardDetalheVue'
import CardConteudoVue from '@/components/localize/CardConteudoVue'
import PublicarConteudoVue from '@/components/localize/PublicarConteudoVue'

export default {
    name: 'Home',
    components: {
        GridVue,
        SiteTemplate,
        CardDetalheVue,
        CardConteudoVue,
        PublicarConteudoVue
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
