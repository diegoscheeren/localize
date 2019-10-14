<template>
   <div class="card-panel grey lighten-5 z-depth-1">
        <div class="row valign-wrapper">
            <slot/>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CardMenuVue',
    props: [],
    data () {
        return {

        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
