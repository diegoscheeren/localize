<template>
   <ul id="slide-out" class="sidenav"><!--fixed-->
    <!-- userbackground -->
  <li><div class="user-view">
      <div class="background" style="background: rgb(43,135,204); background: radial-gradient(circle, rgba(43,135,204,1) 0%, rgba(48,57,59,1) 100%);"></div>
      <a href="#user"><img class="circle" src="http://pluspng.com/img-png/user-png-icon-male-user-icon-512.png"></a>
      <a href="#name"><span class="white-text name">{{usuario.name}}</span></a>
      <a href="#email"><span class="white-text email">{{usuario.email}}</span></a>
    </div></li>
    <!-- userbackground -->
    <li><router-link to="/"><i class="material-icons">home</i> Inicio</router-link></li>
    <li><div class="divider"></div></li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header">Cadastros <i class="material-icons">assignment</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <router-link to="/pesquisa/cliente">
                                <i class="material-icons">person_add</i>
                                Clientes
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/pesquisa/item">
                                <i class="material-icons">local_bar</i>
                                Itens
                            </router-link>
                        </li>
                        <li>
                            <a>
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
    methods: {
        to(rota) {
            this.$router.push(rota);
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
            $('select').not('.disabled').formSelect();
            $('.tabs').tabs();
            $('.tooltipped').tooltip();
            M.updateTextFields();

            $('#search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#tbl tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
