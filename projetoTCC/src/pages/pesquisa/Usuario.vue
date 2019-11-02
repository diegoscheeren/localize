<template>
    <site-template>
        <span slot="principal">
            <h4 class="center">Pesquisa de Usuários</h4>
            <div class="row">
                <input id="search" type="text" placeholder="Pesquisar...">
                </div>
                <div class="row">
                <table class="responsive-table centered">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Admin</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody id="tbl">
                        <tr v-for="dado in dados" :key="dado.id">
                            <td>{{dado.name}}</td>
                            <td>{{dado.email}}</td>
                            <td v-if="dado.is_admin"><i class="material-icons">check</i></td>
                            <td v-if="!dado.is_admin"><i class="material-icons">clear</i></td>
                            <td>
                                <!-- <button class="btn deep-orange tooltipped" @click="editar(dado)"
                                    data-tooltip="Editar" data-position="bottom" title="Editar">
                                    <i class="material-icons">edit</i>
                                </button> -->
                                <button class="btn red tooltipped" @click="excluir(dado.id)"
                                    data-tooltip="Excluir" data-position="bottom" title="Excluir">
                                    <i class="material-icons">delete</i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row center" v-if="load">
                    <div class="preloader-wrapper big active">
                        <div class="spinner-layer spinner-blue-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="gap-patch">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="row">
                <router-link class="btn blue" to="/cadastro/usuario">Novo</router-link>
            </div>
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'PesquisaUsuario',
    data () {
        return {
            dados: {},
            load: true
        }
    },
    components: {
        SiteTemplate
    },
    mounted() {
        this.consultar();
    },
    methods: {
        excluir(id) {
            this.$http.delete(this.$urlAPI + 'usuario', {data: {id: id}})
                .then(resp => {
                     M.toast({
                        html: resp.data.msg,
                        displayLength: 5000,
                        classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                    });
                    this.consultar();
                })
        },
        editar(row) {
            this.$store.commit('setData', row);
            this.$router.push('/cadastro/usuario');
        },
        consultar() {
            this.$http.get(this.$urlAPI + 'usuario')
                .then(resp => {
                    this.dados = resp.data.data;
                    this.load = false;
                    // M.toast({
                    //     html: resp.data.msg,
                    //     displayLength: 5000,
                    //     classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')});
                })
                .catch(e => {
                    M.toast({
                        html: 'Erro ao pesquisar, tente novamente mais tarde',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                    this.load = false;
                })
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
