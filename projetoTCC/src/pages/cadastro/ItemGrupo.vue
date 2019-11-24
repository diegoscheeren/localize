<template>
    <site-template>
        <span slot="principal">
            <h4 class="center" v-if="!this.isEdit">Cadastro de Grupo de Item</h4>
            <h4 class="center" v-if="this.isEdit">Edição de Grupo de Item</h4>
            <form name="form" enctype="multipart/form-data">
                <input type="hidden" name="id" v-model="id">
                <div class="input-field">
                    <label>Descrição</label>
                    <input type="text" name="descricao" v-model="descricao">
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
                Salvar
            </button>
            <router-link class="btn deep-orange right" to="/pesquisa-grupo">Voltar</router-link>
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'ItemGrupo',
    data () {
        return {
            id: '',
            descricao: '',
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
            this.descricao = dados.descricao;
            this.$store.commit('setData', {});
        }
    },
    methods: {
        cadastro() {
            this.btnLoad = true;
            let dados = {
                id: this.id,
                descricao: this.descricao,
            };

            if (this.id) {
                this.$http.put(this.$urlAPI + 'grupo', dados)
                    .then(resp => {
                        M.toast({
                            html: resp.data.msg,
                            displayLength: 5000,
                            classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                        });
                        this.btnLoad = false;
                        this.$router.push('/pesquisa-grupo');
                    })
                    .catch(e => {
                        M.toast({
                            html: 'Erro ao editar, verifique os dados',
                            displayLength: 5000,
                            classes: 'red darken-1'
                        });
                        this.btnLoad = false;
                    })
                return;
            }

            this.$http.post(this.$urlAPI + 'grupo', dados)
                .then(resp => {
                    M.toast({
                        html: resp.data.msg,
                        displayLength: 5000,
                        classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                    });
                    this.btnLoad = false;
                    this.$router.push('/pesquisa-grupo');
                })
                .catch(e => {
                    M.toast({
                        html: 'Erro ao salvar, verifique os dados',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                    this.btnLoad = false;
                })
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
