<template>

    <site-template>

        <span slot="principal">
            <h3 class="center">Cadastro de Item</h3>
            <form name="form" enctype="multipart/form-data">
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
            codigo: '',
            descricao: '',
            valor_custo: '',
            valor_venda: '',
            estoque: '',
            grupo: '',
            unidade_medida: ''
        }
    },
    components: {
        SiteTemplate
    },
    created() {
    },
    methods: {
        cadastro() {
            let dados = {
                codigo: this.codigo,
                descricao: this.descricao,
                valor_custo: this.valor_custo,
                valor_venda: this.valor_venda,
                estoque: this.estoque,
                grupo: this.grupo,
                unidade_medida: this.unidade_medida
            };

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
