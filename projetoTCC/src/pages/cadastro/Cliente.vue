<template>
    <site-template>
        <span slot="principal">
            <h4 class="center" v-if="!this.isEdit">Cadastro de Clientes</h4>
            <h4 class="center" v-if="this.isEdit">Edição de Cliente</h4>
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
                <input type="hidden" name="id" v-model="id">

                <div id="1" class="col s12">
                    <div class="input-field">
                        <label>Nome</label>
                        <input type="text" name="nome" v-model="nome">
                    </div>

                    <div class="input-field">
                        <label>CPF</label>
                        <input @keypress="maskCPF(cpf)" type="text" name="cpf"
                             v-model="cpf" maxlength="14">
                    </div>

                    <div class="input-field">
                        <label>RG</label>
                        <input type="text" name="rg" v-model="rg">
                    </div>

                    <div class="input-field">
                        <label>Data Nasc.</label>
                        <input type="text" name="data_nascimento" class="datepicker" v-model="data_nascimento">
                    </div>
                </div>

                <div id="2" class="col s12">
                    <div class="input-field">
                        <select name="estado" v-model="estado">
                            <option value="" disabled selected>Selecione um estado...</option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                        <label>Estado</label>
                    </div>

                    <div class="input-field">
                        <label>Municipio</label>
                        <input type="text" name="municipio" v-model="municipio">
                    </div>

                    <div class="input-field">
                        <label>Bairro</label>
                        <input type="text" name="bairro" v-model="bairro">
                    </div>

                    <div class="input-field">
                        <label>Endereço</label>
                        <input type="text" name="endereco" v-model="endereco">
                    </div>

                    <div class="input-field">
                        <label>Número</label>
                        <input type="text" name="numero" v-model="numero">
                    </div>

                    <div class="input-field">
                        <label>Complemento</label>
                        <input type="text" name="complemento" v-model="complemento">
                    </div>
                </div>

                <div id="3" class="col s12">
                    <div class="input-field">
                        <label>E-Mail</label>
                        <input type="text" name="email" v-model="email">
                    </div>

                    <div class="input-field">
                        <label>Telefone</label>
                        <input type="text" name="telefone" v-model="telefone">
                    </div>
                </div>
            </form>

            <button class="btn blue darken-1 right" @click="cadastro()">Salvar</button>
            <router-link class="btn deep-orange right" to="/pesquisa/cliente">Voltar</router-link>
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'Cliente',
    data () {
        return {
            id: '',
            rg: '',
            cpf: '',
            nome: '',
            email: '',
            estado: '',
            bairro: '',
            numero: '',
            endereco: '',
            telefone: '',
            municipio: '',
            complemento: '',
            data_nascimento: ''
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
            this.rg = dados.rg;
            this.cpf = dados.cpf;
            this.nome = dados.nome;
            this.email = dados.email;
            this.estado = dados.estado;
            this.bairro = dados.bairro;
            this.numero = dados.numero;
            this.endereco = dados.endereco;
            this.telefone = dados.telefone;
            this.municipio = dados.municipio;
            this.complemento = dados.complemento;
            this.data_nascimento = dados.data_nascimento;
            this.$store.commit('setData', {});
        }
    },
    methods: {
        cadastro() {
            let dados = {
                id: this.id,
                rg: this.rg,
                cpf: this.cpf,
                nome: this.nome,
                email: this.email,
                estado: this.estado,
                bairro: this.bairro,
                numero: this.numero,
                endereco: this.endereco,
                telefone: this.telefone,
                municipio: this.municipio,
                complemento: this.complemento,
                data_nascimento: this.data_nascimento
            };

            if (this.id) {
                this.$http.put(this.$urlAPI + 'cliente', dados)
                    .then(resp => {
                        M.toast({
                            html: resp.data.msg,
                            displayLength: 5000,
                            classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                        });
                        this.$router.push('/pesquisa/cliente');
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

            this.$http.post(this.$urlAPI + 'cliente', dados)
                .then(resp => {
                    M.toast({
                        html: resp.data.msg,
                        displayLength: 5000,
                        classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                    });
                    this.$router.push('/pesquisa/cliente');
                })
                .catch(e => {
                    M.toast({
                        html: 'Erro ao salvar, verifique os dados',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                })
        },
        maskCPF(cpf) {
            cpf = cpf.toString().replace(/\D/g, '')
            cpf = cpf.toString().replace(/(\d{3})(\d)/,"$1.$2")
            cpf = cpf.toString().replace(/(\d{3})(\d)/,"$1.$2")
            cpf = cpf.toString().replace(/(\d{3})(\d{1,2})$/,"$1-$2")
            this.cpf = cpf;
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
