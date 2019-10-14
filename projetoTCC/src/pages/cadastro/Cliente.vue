<template>

    <site-template>

        <span slot="principal">
            <h3 class="center">Cadastro de Cliente</h3>
            <form name="form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs">
                            <li class="tab col s3"><a class="active" href="#1">Dados Gerais</a></li>
                            <li class="tab col s3"><a href="#2">Endereço</a></li>
                            <li class="tab col s3"><a href="#3">Contato</a></li>
                        </ul>
                    </div>
                </div>

                <div id="1" class="col s12">
                    <div class="input-field">
                        <label>Nome</label>
                        <input type="text" name="nome">
                    </div>

                    <div class="input-field">
                        <label>CPF</label>
                        <input type="text" name="cpf">
                    </div>

                    <div class="input-field">
                        <label>RG</label>
                        <input type="text" name="rg">
                    </div>

                    <div class="input-field">
                        <label>Data Nasc.</label>
                        <input type="text" name="data_nascimento" class="datepicker">
                    </div>
                </div>

                <div id="2" class="col s12">
                <div class="input-field">
                        <label>Estado</label>
                        <input type="text" name="estado">
                    </div>

                    <div class="input-field">
                        <label>Municipio</label>
                        <input type="text" name="municipio">
                    </div>

                    <div class="input-field">
                        <label>Bairro</label>
                        <input type="text" name="bairro">
                    </div>

                    <div class="input-field">
                        <label>Endereço</label>
                        <input type="text" name="endereco">
                    </div>

                    <div class="input-field">
                        <label>Número</label>
                        <input type="text" name="numero">
                    </div>

                    <div class="input-field">
                        <label>Complemento</label>
                        <input type="text" name="complemento">
                    </div>
                </div>

                <div id="3" class="col s12">
                    <div class="input-field">
                        <label>E-Mail</label>
                        <input type="text" name="email">
                    </div>

                    <div class="input-field">
                        <label>Telefone</label>
                        <input type="text" name="telefone">
                    </div>
                </div>
            </form>

            <button class="btn blue darken-1 right" @click="cadastro()">Salvar</button>
            <router-link class="btn deep-orange right" to="/">Voltar</router-link>
        </span>
    </site-template>


</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'Cliente',
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
    components:{
        SiteTemplate
    },
    methods: {
        cadastro() {
            // let dados = {
            //     codigo: this.codigo,
            //     descricao: this.descricao,
            //     valor_custo: this.valor_custo,
            //     valor_venda: this.valor_venda,
            //     estoque: this.estoque,
            //     grupo: this.grupo,
            //     unidade_medida: this.unidade_medida
            // };

            // this.$http.post(this.$urlAPI + 'cadastro/item', dados)
            //     .then(resp => {
            //         M.toast({
            //             html: resp.data.msg,
            //             displayLength: 5000,
            //             classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')});
            //     })
            //     .catch(e => {
            //         M.toast({
            //             html: 'Erro ao salvar, verifique os dados',
            //             displayLength: 5000,
            //             classes: 'red darken-1'
            //         });
            //     })
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
