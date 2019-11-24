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
                        <select name="garcom" id="garcom" v-model="garcom"/>
                        <label>Garçom</label>
                    </div>
                </div>

                <div id="2" class="col s12">
                    <div class="row">
                        <table class="responsive-table centered" v-if="!load">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Descrição</th>
                                <th>Grupo</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th>R$ Total</th>
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
                                    <td>{{parseFloat(itemPedido.valor_venda).toFixed(2)}}</td>
                                    <td>{{parseFloat(itemPedido.quantidade * itemPedido.valor_venda).toFixed(2)}}</td>
                                    <td>
                                        <a class="btn-floating green tooltipped" @click="somar(itemPedido, true)"
                                            data-tooltip="Editar" data-position="bottom">
                                            <i class="material-icons">add</i>
                                        </a>
                                        <a class="btn-floating red tooltipped"
                                            @click="(itemPedido.quantidade > 1)
                                                ? subtrair(itemPedido, true)
                                                : removerItemDoPedido(itemPedido)"
                                            data-tooltip="Editar" data-position="bottom">
                                            <i class="material-icons">remove</i>
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
                    <div class="row right">
                        <a class="btn-floating btn-large waves-effect waves-light blue" @click="show()">
                            <i class="material-icons">add</i>
                        </a>
                    </div>
                </div>
            </form>

           <modal name="pesquisa-itens" width="85%" height="95%">
                <div class="container">
                    <!-- <div class="row">
                        <h5 class="col s8">Adicionar Itens ao pedido</h5>
                        <h5 class="col s4" v-if="checked_valor_total !== 0">Total: R$ {{checked_valor_total}}</h5>
                    </div> -->
                    <div class="row">
                        <input class="col s6" @keyup="filtrarItens" id="search" type="text" v-model="search"
                            ref="input" placeholder="Pesquisar...">
                        <i class="material-icons s1" style="cursor: pointer; margin-top: 15px" @click="clear">clear</i>
                        <h5 class="col s4 right">R$ {{checked_valor_total}}</h5>
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
                                    <th>R$ Total</th>
                                    <th>Estoque</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tbla">
                                <tr v-for="item in itensPesquisa.filter(i => i.show)" :key="item.id">
                                    <td>
                                        <label>
                                            <input @change="calcTotalItem" type="checkbox" v-model="item.check"
                                                class="filled-in"/>
                                            <span></span>
                                        </label>
                                    </td>
                                    <td>{{item.descricao}}</td>
                                    <td><b>{{item.quantidade || 0}}</b></td>
                                    <td>{{parseFloat(item.valor_venda).toFixed(2)}}</td>
                                    <td><b>{{parseFloat(item.quantidade * item.valor_venda).toFixed(2)}}</b></td>
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

            <button :class="'btn blue darken-1 right ' + (btnLoad ? 'disabled' : '')" @click="cadastro()">
                <div class="row center" v-if="btnLoad">
                    <div class="preloader-wrapper small active">
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
                Salvar
            </button>
            <router-link class="btn deep-orange right" to="/pesquisa-pedido">Voltar</router-link>
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
            search: '',
            cliente: '',
            valor_total: 0,
            quantidade_pessoas: 1,
            itensPesquisa: [],
            itensPedido: [],
            btnLoad: false,
            isEdit: false,
            load: true,
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
            this.cliente = dados.cliente;
            this.valor_total = dados.valor_total;
            this.quantidade_pessoas = dados.quantidade_pessoas;

            this.setItensPedido(dados.id);

            this.$store.commit('setData', {});
        } else {
            this.load = false;
        }

        this.setGarcom();
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
            this.btnLoad = true;
            let dados = {
                id: this.id,
                mesa: this.mesa,
                garcom: this.garcom,
                cliente: this.cliente,
                valor_total: this.valor_total,
                quantidade_pessoas: this.quantidade_pessoas,
                itens: this.itensPedido
            };

            let garcom = this.$store.getters.getUsuario;
            dados.garcom = $('#garcom').val() || garcom.id;
            dados.cliente = $('#cliente').val() || 1;

            if (this.id) {
                this.$http.put(this.$urlAPI + 'pedido', dados)
                    .then(resp => {
                        M.toast({
                            html: resp.data.msg,
                            displayLength: 5000,
                            classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                        });
                        this.btnLoad = false;
                        this.$router.push('/pesquisa-pedido');
                    })
                    .catch(e => {
                        this.btnLoad = false;
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
                    this.btnLoad = false;
                    this.$router.push('/pesquisa-pedido');
                })
                .catch(e => {
                    M.toast({
                        html: 'Erro ao salvar, verifique os dados',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                    this.btnLoad = false;
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
        filtrarItens(e) {
            const cols = ['descricao', 'quantidade', 'valor_venda', 'estoque'];
            const value = e ? e.target.value.toLowerCase() : '';

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
                    this.load = false;
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
            this.calcTotalGeral();
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
            this.calcTotalGeral();
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
            this.calcTotalItem();
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
            this.calcTotalItem();
        },
        calcTotalItem() {
            this.checked_valor_total = 0;
            for (let item of this.itensPesquisa) {
                this.checked_valor_total += item.check ? (item.quantidade * item.valor_venda) : 0;
            }
            this.calcTotalGeral();
        },
        calcTotalGeral() {
            let total = 0;
            this.itensPedido.forEach(i => {
                total += i.quantidade * i.valor_venda;
            })
            this.valor_total = total;
            M.updateTextFields();
        },
        setItensPedido(id) {
            this.$http.put(this.$urlAPI + 'itens-by-pedido', {id: id})
                .then(resp => {
                    this.itensPedido = resp.data.data;
                    this.calcTotalGeral();
                })
                .catch(e => {
                    M.toast({
                        html: 'Erro ao carregar itens do pedido',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                })
        },
        clear() {
            this.search = '';
            this.filtrarItens(null);
            this.$nextTick(() => {
                this.$refs.input.value = '';
                this.$refs.input.focus();
            });
        }
    }
}
</script>

<style scoped>
</style>


