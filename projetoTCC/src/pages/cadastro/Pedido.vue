<template>

    <site-template>

        <span slot="principal">
            <h4 class="center" v-if="!this.isEdit">Novo Pedido</h4>
            <h4 class="center" v-if="this.isEdit">Edição de Pedido</h4>
            <form name="form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs">
                            <li class="tab col s3"><a href="#1">Dados Gerais</a></li>
                            <li class="tab col s3"><a class="active" href="#2">Itens</a></li>
                        </ul>
                    </div>
                </div>

                <div id="1" class="col s12">
                    <input type="hidden" id="id" name="id">

                    <div class="input-field">
                        <select name="cliente">
                            <option value="0">Consumidor</option>
                        </select>
                        <label>Cliente</label>
                    </div>

                    <div class="input-field">
                        <label>Mesa</label>
                        <input type="text" name="mesa">
                    </div>

                    <div class="input-field">
                        <label>Qtd Pessoas</label>
                        <input type="text" name="quantidade_pessoas">
                    </div>

                    <div class="input-field">
                        <label>Valor Total</label>
                        <input type="text" name="valor_total">
                    </div>

                    <div class="input-field">
                        <select name="status">
                            <option value="1">Em aberto</option>
                            <option value="2">Parcialmente pago</option>
                            <option value="3">Integralmente pago</option>
                        </select>
                        <label>Status</label>
                    </div>

                    <div class="input-field">
                        <select name="garcom">
                            <option></option>
                        </select>
                        <label>Garçom</label>
                    </div>
                </div>

                <div id="2" class="col s12">
                    <div class="row">
                        <table id="pedido-itens" class="responsive-table centered"></table>
                    </div>
                    <div class="row right">
                        <a class="btn-floating btn-large waves-effect waves-light blue tooltipped" @click="show"
                                data-tooltip="Adicionar Item" data-position="left">
                            <i class="material-icons">add</i>
                        </a>
                    </div>
                </div>
            </form>

           <modal name="pesquisa-itens">
                <div class="container">
                    <h4 class="center">Adicionar Itens</h4>
                    <div class="row">
                        <table id="pesquisa-itens" class="responsive-table centered"></table>
                    </div>
                    <div class="row">
                        <a class="btn blue darken-1 right">Adicionar</a>
                        <a class="btn deep-orange right">Voltar</a>
                    </div>
                </div>
            </modal>


            <button class="btn blue darken-1 right" @click="cadastro()">Salvar</button>
            <router-link class="btn deep-orange right" to="/pesquisa/pedido">Voltar</router-link>
        </span>
    </site-template>


</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'Pedido',
    data () {
        return {
            id: '',
            mesa: '',
            garcom: '',
            status: '',
            cliente: '',
            valor_total: '',
            quantidade_pessoas: ''
        }
    },
    components: {
        SiteTemplate
    },
    created() {
        let dados = this.$store.getters.getData;
        this.isEdit = !jQuery.isEmptyObject(this.$store.getters.getData);

        if (!jQuery.isEmptyObject(dados)) {
            this.id = dados.id;
            this.mesa = dados.mesa;
            this.garcom = dados.garcom;
            this.status = dados.status;
            this.cliente = dados.cliente;
            this.valor_total = dados.valor_total;
            this.quantidade_pessoas = dados.quantidade_pessoas;
            this.$store.commit('setData', {});
        }

        this.gridInit;

    },
    methods: {
        show () {
            this.$modal.show('pesquisa-itens');
        },
        hide () {
            this.$modal.hide('pesquisa-itens');
        },
        cadastro() {
            let dados = {
                id: this.id,
                mesa: this.mesa,
                garcom: this.garcom,
                status: this.status,
                cliente: this.cliente,
                valor_total: this.valor_total,
                quantidade_pessoas: this.quantidade_pessoas
            };

            if (this.id) {
                this.$http.put(this.$urlAPI + 'pedido', dados)
                    .then(resp => {
                        M.toast({
                            html: resp.data.msg,
                            displayLength: 5000,
                            classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                        });
                        this.$router.push('/pesquisa/pedido');
                    })
                    .catch(e => {
                        M.toast({
                            html: 'Erro ao editar, verifique os dados',
                            displayLength: 5000,
                            classes: 'red darken-1'
                        });
                    })

                return;
            }

            this.$http.post(this.$urlAPI + 'pedido', dados)
                .then(resp => {
                    M.toast({
                        html: resp.data.msg,
                        displayLength: 5000,
                        classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                    });
                    this.$router.push('/pedido');
                })
                .catch(e => {
                    M.toast({
                        html: 'Erro ao salvar, verifique os dados',
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
