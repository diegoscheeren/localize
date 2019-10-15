<template>

    <site-template>

        <span slot="principal">
            <h4 class="center" v-if="!this.isEdit">Cadastro de Item</h4>
            <h4 class="center" v-if="this.isEdit">Edição de Item</h4>
            <form name="form" enctype="multipart/form-data">
                <input type="hidden" name="id" v-model="id">

                <div class="input-field">
                    <label>Codigo</label>
                    <input type="text" name="codigo" v-model="codigo">
                </div>

                <div class="input-field">
                    <label>Descrição</label>
                    <input type="text" name="descricao" v-model="descricao">
                </div>

                <div class="input-field">
                    <label>Valor Custo</label>
                    <input type="text" name="valor_custo" v-model="valor_custo">
                </div>

                <div class="input-field">
                    <label>Valor Venda</label>
                    <input type="text" name="valor_venda" v-model="valor_venda">
                </div>

                <div class="input-field">
                    <label>Estoque</label>
                    <input type="text" name="estoque" v-model="estoque">
                </div>

                <div class="input-field">
                    <select name="grupo" v-model="grupo">
                        <option value="1">Lanches</option>
                        <option value="2">Porções</option>
                        <option value="2">Bebidas</option>
                    </select>
                    <label>Grupo</label>
                </div>

                <div class="input-field">
                    <select name="unidade_medida" v-model="unidade_medida">
                        <option value="1">Unidade</option>
                        <option value="2">Litros</option>
                        <option value="3">Kg</option>
                    </select>
                    <label>Unidade de Medida</label>
                </div>

                <div class="file-field input-field">
                    <div class="btn">
                        <span>Imagem</span>
                        <input type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
            </form>

            <button class="btn blue darken-1 right" @click="cadastro()">Salvar</button>
            <router-link class="btn deep-orange right" to="/pesquisa/item">Voltar</router-link>
        </span>
    </site-template>


</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'Item',
    data () {
        return {
            id: '',
            codigo: '',
            descricao: '',
            valor_custo: '',
            valor_venda: '',
            estoque: '',
            grupo: '',
            unidade_medida: '',
            isEdit: false
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
            this.unidade_medida = dados.unidade_medida;
            this.$store.commit('setData', {});
        }
    },
    methods: {
        cadastro() {
            let dados = {
                id: this.id,
                grupo: this.grupo,
                codigo: this.codigo,
                estoque: this.estoque,
                descricao: this.descricao,
                valor_custo: this.valor_custo,
                valor_venda: this.valor_venda,
                unidade_medida: this.unidade_medida
            };

            if (this.id) {
                this.$http.put(this.$urlAPI + 'item', dados)
                    .then(resp => {
                        M.toast({
                            html: resp.data.msg,
                            displayLength: 5000,
                            classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                        });
                        this.$router.push('/pesquisa/item');
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

            this.$http.post(this.$urlAPI + 'item', dados)
                .then(resp => {
                    M.toast({
                        html: resp.data.msg,
                        displayLength: 5000,
                        classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                    });
                    this.$router.push('/pesquisa/item');
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
