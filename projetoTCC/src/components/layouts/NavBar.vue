<template>
    <nav :class="cor || 'blue'" style="z-index:1000">
        <a href="#" data-target="slide-out" class="sidenav-trigger show-on-large left-align">
            <i class="material-icons">menu</i>
        </a>
        <div class="nav-wrapper container center">
            <router-link class="brand-logo" :to="url || '/'">{{logo || 'Localize LC'}}</router-link>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <slot/>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'NavBar',
    props: ['logo', 'url', 'cor'],
    data () {
        return {

        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
