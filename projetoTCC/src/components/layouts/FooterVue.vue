<template>
    <footer :class="'page-footer ' + cor">
        <div class="container">
            <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">{{logo || 'Localize'}}</h5>
                <p class="grey-text text-lighten-4">{{descricao || ''}}</p>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                    <slot></slot>
                </ul>
            </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
            © {{ano}} Copyright {{logo}}
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: 'FooterVue',
    props: ['logo', 'descricao', 'cor', 'ano'],
    data () {
        return {

        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
