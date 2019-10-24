<template>
    <site-template>
        <span slot="principal">
            <h4 class="center">Finalizar Comandas</h4>
            <div class="row">
                <input id="search" type="text" placeholder="Pesquisar...">
            </div>
            <div class="row">
                <table class="responsive-table centered" v-if="!load">
                    <thead>
                    <tr>
                        <th>Pedido</th>
                        <th>Cliente</th>
                        <th>Garçom</th>
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
                            <td>{{dado.mesa}}</td>
                            <td>{{dado.valor_total}}</td>
                            <td>
                                <a class="btn red tooltipped waves-effect" @click="finalizar(dado)"
                                    data-tooltip="Finalizar">Finalizar
                                </a>
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
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'PesquisaComanda',
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
        finalizar(row) {
            this.$store.commit('setData', row);
            this.$router.push('/venda/finalizar');
        },
        consultar() {
            this.$http.get(this.$urlAPI + 'pedido')
                .then(resp => {
                    this.dados = resp.data.data;
                    this.load = false;
                    // this.load = false;
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
