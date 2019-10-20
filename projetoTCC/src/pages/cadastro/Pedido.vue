<template>
    <site-template>
        <span slot="principal">
            <h4 class="center" v-if="!this.isEdit">Nova Comanda</h4>
            <h4 class="center" v-if="this.isEdit">Edição de Comanda</h4>
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
                        <label>Quantidade Pessoas</label>
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
                                <th></th>
                                <th>Descrição</th>
                                <th>Grupo</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th>Total</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody id="tbl">
                                <tr v-for="itemPedido in itensPedido" :key="">
                                    <td>
                                        <a class="btn-floating red tooltipped"
                                            @click="removerItemDoPedido(itemPedido)"
                                            data-tooltip="Remover do pedido" data-position="bottom"
                                            title="Remover do pedido">
                                            <i class="material-icons">delete</i>
                                        </a>
                                    </td>
                                    <td>{{itemPedido.descricao}}</td>
                                    <td>{{itemPedido.item_grupo ? itemPedido.item_grupo.descricao : itemPedido.grupo}}</td>
                                    <td><b>{{itemPedido.quantidade}}</b></td>
                                    <td>{{itemPedido.valor_venda}}</td>
                                    <td>{{itemPedido.quantidade * itemPedido.valor_venda}}</td>
                                    <td>
                                        <a class="btn-floating green tooltipped" @click="somar(itemPedido, true)"
                                            data-tooltip="Editar" data-position="bottom">
                                            <i class="material-icons">add</i>
                                        </a>
                                        <a class="btn-floating red tooltipped" @click="subtrair(itemPedido, true)"
                                            data-tooltip="Editar" data-position="bottom">
                                            <i class="material-icons">remove</i>
                                        </a>
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
                    <div class="row">
                        <h5 class="col s8">Adicionar Itens ao pedido</h5>
                        <h5 class="col s4" v-if="checked_valor_total !== 0">Total: R$ {{checked_valor_total}}</h5>
                    </div>
                    <div class="row">
                        <input @keyup="filtrarItens" id="search" type="text" placeholder="Pesquisar...">
                    </div>
                    <div class="row" style="height: 380px; overflow: auto">
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
                                    <th>Total R$</th>
                                    <th>Estoque</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tbla">
                                <tr v-for="item in itensPesquisa.filter(i => i.show)" :key="item.id">
                                    <td>
                                        <label>
                                            <input @change="calcTotal" type="checkbox" v-model="item.check"
                                                class="filled-in"/>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td>{{item.descricao}}</td>
                                    <td><b>{{item.quantidade || 0}}</b></td>
                                    <td>{{item.valor_venda}}</td>
                                    <td><b>{{item.quantidade * item.valor_venda}}</b></td>
                                    <td>{{item.estoque}}</td>
                                    <td>
                                        <button class="btn-floating green tooltipped" @click="somar(item)"
                                            data-tooltip="Editar" data-position="bottom" title="+">
                                            <i class="material-icons">add</i>
                                        </button>
                                        <button class="btn-floating red tooltipped" @click="subtrair(item)"
                                            data-tooltip="Excluir" data-position="bottom" title="-">
                                            <i class="material-icons">remove</i>
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
            valor_total: 0,
            quantidade_pessoas: 1,
            itensPesquisa: [],
            itensPedido: [],
            isEdit: false,
            check: true,
            checked_valor_total: 0
        }
    },
    components: {
        SiteTemplate
    },
    created() {
        let dados = this.$store.getters.getData;
        this.isEdit = !jQuery.isEmptyObject(dados);

        if (this.isEdit) {
            this.id = dados.id;
            this.mesa = dados.mesa;
            this.garcom = dados.garcom;
            this.status = dados.status;
            this.cliente = dados.cliente;
            this.valor_total = dados.valor_total;
            this.quantidade_pessoas = dados.quantidade_pessoas;

            this.setItensPedido(dados.id);

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
            this.itensPesquisa = this.itensPesquisa.map(i => {
                i.check = false;
                i.quantidade = 0;
                return i
            });

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

            let garcom = this.$store.getters.getUsuario;
            dados.garcom = $('#garcom').val() || garcom.id;
            dados.status = $('#status').val() || 0;
            dados.cliente = $('#cliente').val() || 1;

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
            var add = [];
            add = this.itensPesquisa.filter(i => {
                return i.check && i;
            });
            this.itensPedido = this.itensPedido.concat(JSON.parse(JSON.stringify(add)));

            this.checked_valor_total = 0;
            this.hide();
        },
        removerItemDoPedido(item) {
            let voltaEstoque = {id: '', quantidade: 0};
            this.itensPedido = this.itensPedido.filter(i => {
                if (i.id !== item.id) {
                    return i;
                }
                voltaEstoque.id = item.id;
                voltaEstoque.quantidade = item.quantidade;
            });

            this.itensPesquisa.map(i => {
                if (i.id == voltaEstoque.id) {
                    i.estoque += voltaEstoque.quantidade;
                    return i;
                }
            })
        },
        checkAll(e) {
            this.itensPesquisa = this.itensPesquisa.map(i => {
                i.check = e.target.checked;
                return i;
            });
        },
        somar(item, fromPedido = false) {
            fromPedido && this.itensPesquisa.map(i => {
                (item.id === i.id && i.estoque > 0) && i.estoque--;
            })

            if (item.estoque > 0) {
                item.check = true;
                item.quantidade++
                item.estoque--
            } else {
                M.toast({
                    html: 'Item sem estoque',
                    displayLength: 5000,
                    classes: 'red darken-1'
                });
            }
            this.calcTotal();
        },
        subtrair(item, fromPedido = false) {
            fromPedido && this.itensPesquisa.map(i => {
                (item.id === i.id && item.quantidade > 0) && i.estoque++;
            })

            if (item.quantidade > 0) {
                item.quantidade--
                item.estoque++
            }
            if (item.quantidade == 0) {
                item.check = false;
            }
            this.calcTotal();
        },
        calcTotal() {
            this.checked_valor_total = 0;
            for (let item of this.itensPesquisa) {
                this.checked_valor_total += item.check ? (item.quantidade * item.valor_venda) : 0;
            }
        },
        setItensPedido(id) {
            this.$http.put(this.$urlAPI + 'itens-by-pedido', {id: id})
                .then(resp => {
                    this.itensPedido = resp.data.data;
                })
                .catch(e => {
                    M.toast({
                        html: 'Erro ao carregar itens do pedido',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                })
        }
    }
}
</script>

<style scoped>
</style>


