<template>
    <div class="row">
        <div class="card">
            <div class="card-content">
                <div class="row valign-wrapper">
                    <img :src="perfil" alt="nome"
                        class="circle responsive-img">
                    <span class="black-text">
                        <strong>{{nome}}</strong> - <small>{{data}}</small>
                    </span>
                </div>

                <slot></slot>

            </div>
            <div class="card-action">
                <p>
                    <i class="material-icons">favorite_border</i>
                    <i class="material-icons">insert_comment</i>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CardConteudoVue',
    props: ['perfil', 'nome', 'data'],
    data () {
        return {

        }
    },
    components: {
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
