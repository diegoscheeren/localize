<template>
    <site-template>
        <span slot="principal">
            <h5 class="center">Pagamento Comanda Nº {{this.pedido}}</h5>
            <div class="row">
                <div class="card col s12 m5 l4 right">
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
                            <input disabled type="text" v-model="valor_troco" style="color: black;">
                            <label>Troco</label>
                        </div>
                        <div class="input-field">
                            <input disabled type="text" v-model="cliente">
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
                            <a :class="'waves-effect waves-light green accent-3 btn-large '
                                + (btnLoad ? 'disabled' : '')" @click="finalizar">
                            <div class="row center" v-if="btnLoad" style="margin-top: 8px">
                                <div class="preloader-wrapper small active">
                                    <div class="spinner-layer spinner-green-only">
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
                            Finalizar</a>
                        </div>
                    </div>
                </div>

                <div class="card col s12 m6 l7">
                    <table class="responsive-table centered">
                        <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Grupo</th>
                            <th>Quantidade</th>
                            <th>Preço</th>
                            <th>R$ Total</th>
                        </tr>
                        </thead>
                        <tbody id="tbl" v-if="!load">
                            <tr v-for="itemPedido in itensPedido" :key="">
                                <td>{{itemPedido.descricao}}</td>
                                <td>{{itemPedido.item_grupo ? itemPedido.item_grupo.descricao : itemPedido.grupo}}</td>
                                <td><b>{{itemPedido.quantidade}}</b></td>
                                <td>{{parseFloat(itemPedido.valor_venda).toFixed(2)}}</td>
                                <td>{{parseFloat(itemPedido.quantidade * itemPedido.valor_venda).toFixed(2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row center" v-if="load" style="margin-top: 20px">
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
                    <div class="card-content right" style="color: black;">
                        <b>Total a pagar: R$ {{parseFloat(this.valor_total).toFixed(2)}}</b>
                    </div>
                    <div class="input-field">
                        <router-link class="btn deep-orange" to="/venda-comanda">Voltar</router-link>
                    </div>
                </div>
            </div>
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
            pedido: '',
            cliente: ' ',
            itensPedido: [],
            isEdit: {},
            load: true,
            btnLoad: false
        }
    },
    components: {
        SiteTemplate
    },
    created() {
        let dados = this.$store.getters.getData;
        this.isData = !jQuery.isEmptyObject(dados);

        if (this.isData) {
            this.valor_total = dados.valor_total;
            this.cliente = dados.pedido_cliente.nome;
            this.pedido = dados.id;
            this.setItensPedido(dados.id);
            this.$store.commit('setData', {});
        }
    },
    methods: {
        setItensPedido(id) {
            this.$http.put(this.$urlAPI + 'itens-by-pedido', {id: id})
                .then(resp => {
                    this.itensPedido = resp.data.data;
                    this.load = false;
                })
                .catch(e => {
                    M.toast({
                        html: 'Erro ao carregar itens do pedido',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                })
        },
        calcTroco() {
            let troco = (this.valor_pago - this.valor_total).toFixed(2);
            this.valor_troco = (troco >= 0) ? troco : 0;
        },
        finalizar() {
            this.btnLoad = true;

            let dados = {pedido: this.pedido};
             this.$http.post(this.$urlAPI + 'finalizar-pedido', dados)
                .then(resp => {
                    M.toast({
                        html: resp.data.msg,
                        displayLength: 5000,
                        classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                    });
                    this.btnLoad = false;
                    (resp.data.status == true) && this.$router.push('/venda-comanda')
                })
                .catch(e => {
                    M.toast({
                        html: 'Erro ao finalizar pedido',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                    this.btnLoad = false;
                })
        }
    }
}
</script>

<style scoped>
</style>
