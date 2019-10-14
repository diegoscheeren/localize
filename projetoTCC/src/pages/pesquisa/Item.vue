<template>

    <site-template>

        <span slot="principal">
            <h3 class="center">Pesquisa de Item</h3>
            <div class="row">
                <input id="search" type="text" placeholder="Pesquisar...">
                </div>
                <div class="row">
                <table class="responsive-table centered">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Grupo</th>
                        <th>Un. Medida</th>
                        <th>Custo</th>
                        <th>Preço</th>
                        <th>Estoque</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody id="tbl">
                        <tr v-for="dado in dados" :key="dado.id">
                            <td>{{dado.codigo}}</td>
                            <td>{{dado.descricao}}</td>
                            <td>{{dado.grupo}}</td>
                            <td>{{dado.unidade_medida}}</td>
                            <td>{{dado.valor_custo}}</td>
                            <td>{{dado.valor_venda}}</td>
                            <td>{{dado.estoque}}</td>
                            <td>
                                <button class="btn deep-orange tooltipped" @click="excluir(dado.id)"
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
                </div>
                <div class="row">
                <router-link class="btn blue" to="/cadastro/item">Adicionar</router-link>
            </div>

        </span>
    </site-template>

</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'PesquisaItem',
    data () {
        return {
            dados: {}
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
        consultar() {
            this.$http.get(this.$urlAPI + 'item')
                .then(resp => {
                    this.dados = resp.data.data;
                    M.toast({
                        html: resp.data.msg,
                        displayLength: 5000,
                        classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')});
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
