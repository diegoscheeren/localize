<template>
    <site-template>
        <span slot="principal">
            <h4 class="center">Acerto de Estoque</h4>
            <form name="form" enctype="multipart/form-data">
                <input type="hidden" name="id" v-model="id">

                <div class="input-field">
                    <label>Código</label>
                    <input type="text" name="codigo" v-model="codigo" readonly>
                </div>

                <div class="input-field">
                    <label>Descrição</label>
                    <input type="text" name="descricao" v-model="descricao" readonly>
                </div>

                <div class="input-field">
                    <label>Novo Custo</label>
                    <input type="text" name="valor_custo" v-model="valor_custo">
                </div>

                <div class="input-field">
                    <label>Novo Valor de Venda</label>
                    <input type="text" name="valor_venda" v-model="valor_venda">
                </div>

                <div class="input-field">
                    <label>Quantidade</label>
                    <input type="text" name="estoque" v-model="estoque">
                </div>

                <div class="input-field">
                    <label>Observação</label>
                    <input type="text" name="observacao" v-model="observacao">
                </div>
            </form>

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
                Concluir
            </button>
            <router-link class="btn deep-orange right" to="/pesquisa/estoque">Voltar</router-link>
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'AcertoEstoque',
    data () {
        return {
            id: '',
            grupo: '',
            codigo: '',
            estoque: '',
            descricao: '',
            observacao: '',
            valor_custo: '',
            valor_venda: '',
            isEdit: false,
            btnLoad: false
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
            this.grupo = dados.grupo;
            this.codigo = dados.codigo;
            this.estoque = dados.estoque;
            this.descricao = dados.descricao;
            this.valor_custo = dados.valor_custo;
            this.valor_venda = dados.valor_venda;
            this.unidade_medida = dados.unidade_medida.id;

            this.$store.commit('setData', {});
        }
    },
    methods: {
        cadastro() {
            this.btnLoad = true;

            let dados = {
                id: this.id,
                codigo: this.codigo,
                estoque: this.estoque,
                descricao: this.descricao,
                valor_custo: this.valor_custo,
                valor_venda: this.valor_venda,
                observacao: this.observacao
            };

            this.$http.post(this.$urlAPI + 'estoque', dados)
                .then(resp => {
                    M.toast({
                        html: resp.data.msg,
                        displayLength: 5000,
                        classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                    });
                    this.btnLoad = false;
                    this.$router.push('/pesquisa/estoque');
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
    }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
