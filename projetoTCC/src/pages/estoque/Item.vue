<template>
    <site-template>
        <span slot="principal">
            <h4 class="center">Acerto de Estoque</h4>
            <div class="row">
                <input id="search" type="text" placeholder="Pesquisar...">
            </div>
            <div class="row">
                <table class="responsive-table centered" v-if="!load">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Grupo</th>
                        <th>Custo</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody id="tbl">
                        <tr v-for="dado in dados" :key="dado.id" :style="(dado.estoque <= 0) ? 'color: red;' : ''">
                            <td>{{dado.codigo}}</td>
                            <td>{{dado.descricao}}</td>
                            <td>{{dado.item_grupo.descricao}}</td>
                            <td>{{parseFloat(dado.valor_custo).toFixed(2)}}</td>
                            <td>{{parseFloat(dado.valor_venda).toFixed(2)}}</td>
                            <td><b>{{dado.estoque}}</b></td>
                            <td>
                                <button class="btn deep-orange tooltipped" @click="editar(dado)"
                                    data-tooltip="Editar" data-position="bottom" title="Editar">
                                    Efetuar Acerto
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
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'PesquisaEstoque',
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
            this.$http.delete(this.$urlAPI + 'item', {data: {id: id}})
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
            this.$router.push('/estoque-acerto');
        },
        consultar() {
            this.$http.get(this.$urlAPI + 'item')
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
