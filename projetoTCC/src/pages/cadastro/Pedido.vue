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
                    <input type="hidden" id="id" name="id" v-model="id">

                    <div class="input-field">
                        <select name="cliente" id="cliente" v-model="cliente"/>
                        <label>Cliente</label>
                    </div>

                    <div class="input-field">
                        <label>Mesa</label>
                        <input type="text" name="mesa" v-model="mesa">
                    </div>

                    <div class="input-field">
                        <label>Qtd Pessoas</label>
                        <input type="text" name="quantidade_pessoas" v-model="quantidade_pessoas">
                    </div>

                    <div class="input-field">
                        <label>Valor Total</label>
                        <input type="text" name="valor_total" v-model="valor_total">
                    </div>

                    <div class="input-field">
                        <select name="status" id="status" v-model="status"/>
                        <label>Status</label>
                    </div>

                    <div class="input-field">
                        <select name="garcom" id="garcom" v-model="garcom"/>
                        <label>Garçom</label>
                    </div>
                </div>

                <div id="2" class="col s12">
                    <div class="row">
                        <table class="responsive-table centered">
                            <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Grupo</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th>Total</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody id="tbl">
                                <tr v-for="itemPedido in itensPedido" :key="itemPedido.id">
                                    <td>{{itemPedido.descricao}}</td>
                                    <td>{{itemPedido.item_grupo.descricao}}</td>
                                    <td><b>{{itemPedido.quantidade || 0}}</b></td>
                                    <td>{{itemPedido.valor_venda}}</td>
                                    <td>{{itemPedido.total}}</td>
                                    <td>
                                        <button class="btn deep-orange tooltipped" @click="editar(itemPedido)"
                                            data-tooltip="Editar" data-position="bottom" title="Editar">
                                            <i class="material-icons">edit</i>
                                        </button>
                                        <button class="btn red tooltipped" @click="excluir(itemPedido.id)"
                                            data-tooltip="Excluir" data-position="bottom" title="Excluir">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row right">
                        <a class="btn-floating btn-large waves-effect waves-light blue tooltipped" @click="show()"
                                data-tooltip="Adicionar Item" data-position="left">
                            <i class="material-icons">add</i>
                        </a>
                    </div>
                </div>
            </form>

           <modal name="pesquisa-itens" width="85%" height="95%">
                <div class="container">
                    <h5 class="center">Adicionar Itens</h5>
                    <div class="row">
                        <input @keyup="filtrarItens" id="search" type="text" placeholder="Pesquisar...">
                    </div>
                    <div class="row" style="height: 390px; overflow: auto">
                        <table class="responsive-table centered">
                            <thead>
                                <tr>
                                    <th>
                                        <label>
                                            <input @change="checkAll" type="checkbox" class="filled-in"/>
                                            <span></span>
                                        </label>
                                    </th>
                                    <th>Descrição</th>
                                    <th>Quantidade</th>
                                    <th>Preço</th>
                                    <th>Estoque</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tbla">
                                <tr v-for="item in itensPesquisa.filter(i => i.show)" :key="item.id">
                                    <td>
                                        <label>
                                            <input type="checkbox" class="filled-in" v-model="item.check"/>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td>{{item.descricao}}</td>
                                    <td><b>{{item.quantidade || 0}}</b></td>
                                    <td>{{item.valor_venda}}</td>
                                    <td>{{item.estoque}}</td>
                                    <td>
                                        <button class="btn-floating green tooltipped" @click="editar(item)"
                                            data-tooltip="Editar" data-position="bottom" title="+">
                                            +
                                        </button>
                                        <button class="btn-floating red tooltipped" @click="excluir(item.id)"
                                            data-tooltip="Excluir" data-position="bottom" title="-">
                                            -
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <a @click="addItensNoPedido()" class="btn blue darken-1 right">Adicionar</a>
                        <a @click="hide()" class="btn deep-orange right">Voltar</a>
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
            quantidade_pessoas: '',
            itensPesquisa: [],
            itensPedido: [],
            isEdit: false,
            check:true
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

        this.setGarcom();
        this.setStatus();
        this.setClientes();
        this.setItensPesquisa();
    },
    methods: {
        show() {
            // Não está limpando os checkboxes apos adicionar um item
            for (let i in this.itensPesquisa) {
                this.itensPesquisa[i]['check'] = false;
            }
            this.$modal.show('pesquisa-itens');
        },
        hide() {
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
                quantidade_pessoas: this.quantidade_pessoas,
                itens: this.itensPedido
            };
            console.log(this.itensPedido)

            dados.garcom = $('#garcom').val();
            dados.status = $('#status').val();
            dados.cliente = $('#cliente').val();

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
        setGarcom() {
            let usuario = this.$store.getters.getUsuario;
            if (usuario) {
                setTimeout(() => {
                    $('#garcom').append(new Option(usuario.name, usuario.id, true, true));
                    $('select').formSelect();
                }, 500);
            }
        },
        setClientes() {
            this.$http.get(this.$urlAPI + 'cliente')
                .then(resp => {
                    let dados = resp.data.data;

                    dados.forEach(d => $('#cliente').append(new Option(d.nome, d.id, false, (d.id == this.cliente))));
                    $('select').formSelect();
                }).catch(e => {
                    M.toast({
                        html: 'Erro ao buscar clientes, tente novamente',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                });
        },
        setStatus() {
            this.$http.get(this.$urlAPI + 'status')
                .then(resp => {
                    let dados = resp.data.data;
                    dados.forEach(d => $('#status').append(new Option(d.descricao, d.id, false, (d.id == this.cliente))));
                    $('select').formSelect();
                }).catch(e => {
                    M.toast({
                        html: 'Erro ao buscar status, tente novamente',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                });
        },
        filtrarItens(e) {
            const cols = ['descricao', 'quantidade', 'valor_venda', 'estoque'];
            const value = e.target.value.toLowerCase();

            this.itensPesquisa = this.itensPesquisa.map(i => {
                const search = [];
                Object.keys(i).forEach(k => cols.includes(k) && i[k] && search.push(i[k]));
                i.show = search.join('').toLowerCase().indexOf(value) !== -1;
                return i;
            });
        },
        setItensPesquisa() {
            this.$http.get(this.$urlAPI + 'item')
                .then(resp => {
                    this.itensPesquisa = resp.data.data.map(i => {
                        i.show = true;
                        i.check = false;
                        i.quantidade = 0;
                        return i;
                    });
                })
                .catch(e => {
                    M.toast({
                        html: 'Erro ao pesquisar, tente novamente mais tarde',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                })
        },
        addItensNoPedido() {
            for (let item of this.itensPesquisa) {
                item.check && this.itensPedido.push(item);
            }
            this.hide();
            // console.log(this.itensPedido)
        },
        checkAll(e) {
            this.itensPesquisa = this.itensPesquisa.map(i => {
                i.check = e.target.checked;
                return i;
            });
        }
    }
}
</script>

<style scoped>
/* EXEMPLO DE FILTRO */

/* computed: {
    items () {
        return this.keyword
            ? this.dataArray.filter(item =>
                item.firstname.includes(this.keyword) ||
                item.lastname.includes(this.keyword) || i
                tem.email.includes(this.keyword))
            : this.dataArray
    }
} */
</style>


