<template>
    <site-template>
        <span slot="principal">
            <h4 class="center">Pesquisa de Comandas</h4>
            <div class="row">
                <div class="col s1" style="margin-top: 20px;"
                    title="Com esta opção marcada somente serão listadas comandas FINALIZADAS">
                    <label>
                        <input @change="consultar" type="checkbox" class="filled-in"
                            v-model="somenteFinalizados"/>
                        <span></span>
                    </label>
                </div>
                <div class="col s11">
                    <input id="search" type="text" placeholder="Pesquisar...">
                </div>
            </div>
            <div class="row">
                <table class="responsive-table centered" v-if="!load">
                    <thead>
                    <tr>
                        <th>Pedido</th>
                        <th>Cliente</th>
                        <th>Garçom</th>
                        <th>Pessoas</th>
                        <th>Mesa</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody id="tbl">
                        <tr v-for="dado in dados" :key="dado.id">
                            <td>{{dado.id}}</td>
                            <td>{{dado.pedido_cliente.nome}}</td>
                            <td>{{dado.pedido_garcom.name || ''}}</td>
                            <td>{{dado.quantidade_pessoas}}</td>
                            <td>{{dado.mesa}}</td>
                            <td>{{dado.valor_total}}</td>
                            <td>
                                <button class="btn deep-orange tooltipped" @click="editar(dado)"
                                    data-tooltip="Editar">
                                    <i class="material-icons">edit</i>
                                </button>
                                <button class="btn red tooltipped" @click="excluir(dado.id)"
                                    data-tooltip="Excluir">
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
                <router-link class="btn blue" to="/cadastro/pedido">Novo</router-link>
            </div>
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'PesquisaPedido',
    data () {
        return {
            dados: {},
            load: true,
            somenteFinalizados: true
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
            this.$http.delete(this.$urlAPI + 'pedido', {data: {id: id}})
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
            this.$router.push('/cadastro/pedido');
        },
        consultar() {
            this.load = true;
            this.$http.get(this.$urlAPI + 'pedido', {params: {filter: this.somenteFinalizados}})
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
