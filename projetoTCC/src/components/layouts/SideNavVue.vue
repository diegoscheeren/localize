<template>
    <ul id="slide-out" class="sidenav"><!--fixed-->
        <!-- userbackground -->
    <li>
        <div class="user-view">
            <div class="background"
                style="background: linear-gradient(90deg, rgba(22,22,23,1) 22%, rgba(95,96,96,1) 83%);">
            </div>
            <a href="#user">
                <img :src="(usuario.imagem === 'http://localhost:8000/')
                    ? 'http://localhost:8000/perfis/perfil_default/default.png' : usuario.imagem"
                    class="circle responsive-img">
            </a>
            <a href="#name"><span class="white-text name" style="font-size: 15px">{{usuario.name}}</span></a>
            <a href="#email"><span class="white-text email" style="font-size: 15px">{{usuario.email}}</span></a>
        </div>
    </li>
    <!-- userbackground -->
    <li>
        <a @click="close" class="waves-effect"><i class="material-icons">home</i> Inicio</a>
    </li>
    <li>
        <div class="divider"></div>
    </li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header">Cadastros <i class="material-icons">assignment</i></a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <router-link class="waves-effect" to="/pesquisa/cliente">
                                <i class="material-icons">person_add</i>
                                Clientes
                            </router-link>
                        </li>
                        <li>
                            <router-link class="waves-effect" to="/pesquisa/item">
                                <i class="material-icons">local_bar</i>
                                Itens
                            </router-link>
                        </li>
                        <li>
                            <router-link class="waves-effect" to="/pesquisa/unidade-medida">
                                <i class="material-icons">settings_ethernet</i>
                                Unidades de medida
                            </router-link>
                        </li>
                        <li>
                            <router-link class="waves-effect" to="/pesquisa/grupo">
                                <i class="material-icons">group_work</i>
                                Grupos de itens
                            </router-link>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <li><div class="divider"></div></li>
    <li class="no-padding">
        <router-link class="waves-effect" to="/pesquisa/pedido">
            <i class="material-icons">note_add</i>
            Comandas
        </router-link>
    </li>
    <li><div class="divider"></div></li>
    <li class="no-padding">
        <router-link class="waves-effect" to="/venda/comanda">
            <i class="material-icons">monetization_on</i>
            Vendas
        </router-link>
    </li>
    <li><div class="divider"></div></li>
    <li class="no-padding">
        <router-link class="waves-effect" to="/venda/comanda">
            <i class="material-icons">apps</i>
            Estoque
        </router-link>
    </li>
    <li><div class="divider"></div></li>
    <li class="no-padding">
        <router-link class="waves-effect" to="/pesquisa/usuario">
            <i class="material-icons">group</i>
            Usuários
        </router-link>
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
        close() {
            $('.sidenav').sidenav('close');
            (this.$route.path != '/') && this.$router.push('/');
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
            $('select').formSelect();
            $('.tabs').tabs();
            $('.tooltipped').tooltip();
            M.updateTextFields();

            $('select').on('contentChanged', function() {
                $(this).formSelect();
            });

            // overlay bug e scroll
            $('div.sidenav-overlay').remove();
            $('html').css('overflow', 'auto');

            $('table').addClass('responsive-table centered');

            $('#search').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('table tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('.datepicker').datepicker({
                months: [
                    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                ],
                monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabádo'],
                weekdaysAbbrev: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                today: 'Hoje',
                clear: 'Limpar',
                close: 'Pronto',
                labelMonthNext: 'Próximo mês',
                labelMonthPrev: 'Mês anterior',
                labelMonthSelect: 'Selecione um mês',
                labelYearSelect: 'Selecione um ano',
                selectMonths: true,
                selectYears: 150,
                format: 'dd/mm/yyyy'
            });
        });
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
