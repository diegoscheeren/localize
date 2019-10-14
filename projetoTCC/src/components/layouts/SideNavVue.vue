<template>
   <ul id="slide-out" class="sidenav"><!--fixed-->
    <!-- userbackground -->
  <li><div class="user-view">
      <div class="background">
        <img src="https://materializecss.com/images/office.jpg">
      </div>
      <a href="#user"><img class="circle" src="https://materializecss.com/images/yuna.jpg"></a>
      <a href="#name"><span class="white-text name">{{usuario.name}}</span></a>
      <a href="#email"><span class="white-text email">{{usuario.email}}</span></a>
    </div></li>
    <!-- userbackground -->
    <li><a class="waves-effect"><i class="material-icons">home</i> Inicio</a></li>
    <li><div class="divider"></div></li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header">Cadastros <i class="material-icons">assignment</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <a href="">
                                <i class="material-icons">person_add</i>
                                Clientes
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="material-icons">local_bar</i>
                                Itens
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="material-icons">settings_ethernet</i>
                                Unidades de medida
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="material-icons">group_work</i>
                                Grupos de itens
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <li><div class="divider"></div></li>
    <li class="no-padding">
        <a class="waves-effect" href="">
            <i class="material-icons">note_add</i>
            Pedidos
        </a>
    </li>
    <li><div class="divider"></div></li>
    <li class="no-padding">
        <a class="waves-effect" href="">
            <i class="material-icons">group</i>
            Usuários
        </a>
    </li>
 </ul>
</template>

<script>
export default {
    name: 'SideNavVue',
    props: ['logo', 'url', 'cor'],
    data () {
        return {
            usuario: false
        }
    },
    created() {
        let usuarioAux = this.$store.getters.getUsuario;
        if (usuarioAux) {
            this.usuario = this.$store.getters.getUsuario;
        } else {
            this.$router.push('/login');
        }

        $(document).ready(function() {
            $('.sidenav').sidenav();
            $('.collapsible').collapsible();
        });
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
