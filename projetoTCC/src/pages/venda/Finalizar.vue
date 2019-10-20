<template>
    <site-template>
        <span slot="principal">
            <h4 class="center" v-if="!this.isEdit">Finalizar Comanda Nº</h4>
            <form name="form" enctype="multipart/form-data">
                <div class="card col s7">
                    <table class="responsive-table centered">
                        <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Grupo</th>
                            <th>Quantidade</th>
                            <th>Preço</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody id="tbl">
                            <!-- <tr v-for="itemPedido in itensPedido" :key="">
                                <td>{{itemPedido.descricao}}</td>
                                <td>{{itemPedido.item_grupo ? itemPedido.item_grupo.descricao : itemPedido.grupo}}</td>
                                <td><b>{{itemPedido.quantidade}}</b></td>
                                <td>{{itemPedido.valor_venda}}</td>
                                <td>{{itemPedido.quantidade * itemPedido.valor_venda}}</td>
                            </tr> -->
                        </tbody>
                    </table>
                    <div class="card-content">
                        Total a pagar: R$ 0,00
                    </div>
                    <div class="input-field">
                        <router-link class="btn deep-orange" to="/venda/comanda">Voltar</router-link>
                    </div>
                </div>

                <div class="col s1"/>

                <div class="card col s4">
                    <span class="card-title">
                        <div class="row center">Pagamento</div>
                    </span>
                    <div class="card-content" style="margin-top: -40px">
                        <div class="input-field">
                            <input disabled type="text" v-model="valor_total">
                            <label>Valor Total</label>
                        </div>
                        <div class="input-field">
                            <input v-focus type="text" @keyup="calcTroco" v-model="valor_pago">
                            <label>Valor Pago</label>
                        </div>
                        <div class="input-field">
                            <input disabled type="text" v-model="valor_troco">
                            <label>Troco</label>
                        </div>
                        <div class="input-field">
                            <input type="text" v-model="cliente">
                            <label>Cliente</label>
                        </div>
                        <div class="input-field">
                            <select>
                                <!-- <option value="" disabled selected>Selecione...</option> -->
                                <option value="1">Dinheiro</option>
                                <option value="2">Cartão Débito</option>
                                <option value="3">Cartão Crédito</option>
                            </select>
                            <label>Forma de Pagamento</label>
                        </div>
                        <div class="input-field center">
                            <a class="waves-effect waves-light green accent-3 btn-large">Finalizar</a>
                        </div>
                    </div>
                </div>
            </form>
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'Finalizar',
    data () {
        return {
            valor_total: 50,
            valor_pago: '',
            valor_troco: 0,
            cliente: ' ',
            isEdit: {}
        }
    },
    components: {
        SiteTemplate
    },
    created() {
        let dados = this.$store.getters.getData;
        this.isEdit = !jQuery.isEmptyObject(dados);

        if (this.isEdit) {

            this.$store.commit('setData', {});
        }

    },
    methods: {
        cadastro() {
            let dados = {};

            let garcom = this.$store.getters.getUsuario;

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
                    this.$router.push('/pesquisa/pedido');
                })
                .catch(e => {
                    M.toast({
                        html: 'Erro ao salvar, verifique os dados',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                })
        },
        calcTroco() {
            this.valor_troco = (this.valor_pago - this.valor_total).toFixed(2);
        }
    }
}
</script>

<style scoped>

</style>
