<template>
    <site-template>
        <span slot="principal">
            <h4 class="center" v-if="!this.isEdit">Cadastro de Unidade de Medida</h4>
            <h4 class="center" v-if="this.isEdit">Edição de Unidade de Medida</h4>
            <form name="form" enctype="multipart/form-data">
                <input type="hidden" name="id" v-model="id">

                <div class="input-field">
                    <label>Abreviação</label>
                    <input type="text" name="abreviacao" v-model="abreviacao">
                </div>

                <div class="input-field">
                    <label>Descrição</label>
                    <input type="text" name="descricao" v-model="descricao">
                </div>

                <div class="input-field">
                    <label>Quantidade</label>
                    <input type="text" name="quantidade" v-model="quantidade">
                </div>
            </form>

            <button class="btn blue darken-1 right" @click="cadastro()">Salvar</button>
            <router-link class="btn deep-orange right" to="/pesquisa-unidade-medida">Voltar</router-link>
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'UnidadeMedida',
    data () {
        return {
            id: '',
            abreviacao: '',
            descricao: '',
            quantidade: '',
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
            this.abreviacao = dados.abreviacao;
            this.descricao = dados.descricao;
            this.quantidade = dados.quantidade;
            this.$store.commit('setData', {});
        }
    },
    methods: {
        cadastro() {
            let dados = {
                id: this.id,
                abreviacao: this.abreviacao,
                descricao: this.descricao,
                quantidade: this.quantidade
            };

            if (this.id) {
                this.$http.put(this.$urlAPI + 'unidade-medida', dados)
                    .then(resp => {
                        M.toast({
                            html: resp.data.msg,
                            displayLength: 5000,
                            classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                        });
                        this.$router.push('/pesquisa-unidade-medida');
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

            this.$http.post(this.$urlAPI + 'unidade-medida', dados)
                .then(resp => {
                    M.toast({
                        html: resp.data.msg,
                        displayLength: 5000,
                        classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                    });
                    this.$router.push('/pesquisa-unidade-medida');
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
