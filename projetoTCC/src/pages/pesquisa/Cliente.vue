<template>
    <site-template>
        <span slot="principal">
            <h4 class="center">Pesquisa de Clientes</h4>
            <div class="row">
                <input id="search" type="text" placeholder="Pesquisar...">
            </div>
            <div class="row">
                <table class="responsive-table centered" v-if="!load">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>RG</th>
                        <th>Telefone</th>
                        <th>Município</th>
                        <th>Endereço</th>
                        <th>Bairro</th>
                        <th>Número</th>
                        <th>Complemento</th>
                        <th v-if="isAdmin">Ações</th>
                    </tr>
                    </thead>
                    <tbody id="tbl">
                        <tr v-for="dado in dados" :key="dado.id">
                            <td>{{dado.nome}}</td>
                            <td>{{dado.cpf}}</td>
                            <td>{{dado.rg}}</td>
                            <td>{{dado.telefone}}</td>
                            <td>{{dado.municipio}}</td>
                            <td>{{dado.endereco}}</td>
                            <td>{{dado.bairro}}</td>
                            <td>{{dado.numero}}</td>
                            <td>{{dado.complemento}}</td>
                            <td v-if="isAdmin">
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
            <div class="row" v-if="isAdmin">
                <router-link class="btn blue" to="/cadastro-cliente">Novo</router-link>
            </div>
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'PesquisaCliente',
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
            this.$http.delete(this.$urlAPI + 'cliente', {data: {id: id}})
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
            this.$router.push('/cadastro-cliente');
        },
        consultar() {
            this.$http.get(this.$urlAPI + 'cliente')
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
