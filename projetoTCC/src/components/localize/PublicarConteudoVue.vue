<template>
    <div class="row">
        <grid-vue class="input-field" tamanho="12">
            <textarea class="materialize-textarea" v-model="conteudo"></textarea>
            <label>Como voce se sente?</label>
        </grid-vue>
        <p>
            <grid-vue v-if="conteudo" class="btn waves-effect waves-light" tamanho="2 offset-s10">Pulbicar</grid-vue>
        </p>
    </div>
</template>

<script>
import GridVue from '@/components/layouts/GridVue'

export default {
    name: 'PublicarConteudoVue',
    props: [],
    data () {
        return {
            conteudo: ''
        }
    },
    components: {
        GridVue
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
