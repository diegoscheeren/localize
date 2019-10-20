<template>
    <nav :class="cor || 'blue'" style="z-index:1000">
        <a v-if="user" href="#" data-target="slide-out" class="sidenav-trigger show-on-large left-align">
            <i class="material-icons">menu</i>
        </a>
        <div class="nav-wrapper center">
            <a @click="close" style="cursor:pointer" class="brand-logo center">{{logo || 'Localize'}}</a>
            <ul id="nav-mobile" class="right"> <!--hide-on-med-and-down-->
                <slot/>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'NavBar',
    props: ['logo', 'url', 'cor', 'user'],
    data () {
        return {
        }
    },
    methods: {
        close() {
            $('.sidenav').sidenav('close');
            (this.$route.path != '/') && this.$router.push('/');
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
