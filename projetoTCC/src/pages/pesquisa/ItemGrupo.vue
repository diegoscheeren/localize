<template>
    <site-template>
        <span slot="principal">
            <h4 class="center">Pesquisa de Grupos de Itens</h4>
            <div class="row">
                <input id="search" type="text" placeholder="Pesquisar...">
            </div>
            <div class="row">
                <table class="responsive-table centered">
                    <thead>
                    <tr>
                        <th>Descrição</th>
                        <th v-if="isAdmin">Ações</th>
                    </tr>
                    </thead>
                    <tbody id="tbl">
                        <tr v-for="dado in dados" :key="dado.id">
                            <td>{{dado.descricao}}</td>
                            <td v-if="isAdmin">
                                <button class="btn deep-orange tooltipped" @click="editar(dado)"
                                    data-tooltip="Editar" data-position="bottom" title="Editar">
                                    <i class="material-icons">edit</i>
                                </button>
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
            <div class="row" v-if="isAdmin">
                <router-link class="btn blue" to="/cadastro-grupo">Novo</router-link>
            </div>
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'PesquisaItemGrupo',
    data () {
        return {
            dados: {},
            load: true,
            isAdmin: false
        }
    },
    components: {
        SiteTemplate
    },
    mounted() {
        this.consultar();
        this.isAdmin = this.$store.getters.isAdmin;
    },
    methods: {
        excluir(id) {
            this.$http.delete(this.$urlAPI + 'grupo', {data: {id: id}})
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
            this.$router.push('/cadastro-grupo');
        },
        consultar() {
            this.$http.get(this.$urlAPI + 'grupo')
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
                })
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
