<template>
    <site-template>
        <span slot="principal">
            <h4 class="center" v-if="!this.isEdit">Cadastro de Usuário</h4>
            <h4 class="center" v-if="this.isEdit">Edição de Usuário</h4>
            <form name="form" enctype="multipart/form-data">
                <input type="hidden" name="id" v-model="id">

                <div class="input-field">
                    <label>Nome</label>
                    <input type="text" name="name" v-model="name">
                </div>

                <div class="input-field">
                    <label>E-Mail</label>
                    <input type="email" class="validate" name="email" v-model="email">
                    <span class="helper-text" data-error="E-Mail inválido"></span>
                </div>

                <div class="input-field">
                    <label>Senha</label>
                    <input type="password" name="password" v-model="password">
                </div>

                <div class="input-field">
                    <label>Confimação da senha</label>
                    <input type="password" name="confirm_password" v-model="confirm_password">
                </div>

                <label>
                    <input name="is_admin" type="checkbox"  v-model="is_admin"/>
                    <span>Administrador</span>
                </label>

            </form>
            <button class="btn blue darken-1 right" @click="cadastro()">Salvar</button>
            <router-link class="btn deep-orange right" to="/pesquisa-usuario">Voltar</router-link>
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'Usuario',
    data () {
        return {
            id: '',
            name: '',
            email: '',
            password: '',
            confirm_password: '',
            is_admin: false,
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
            this.name = dados.name;
            this.email = dados.email;
            this.is_admin = dados.is_admin;
            this.password = dados.password;
            this.confirm_password = dados.confirm_password;
            this.$store.commit('setData', {});
        }
    },
    methods: {
        cadastro() {
            let dados = {
                id: this.id,
                name: this.name,
                email: this.email,
                is_admin: this.is_admin,
                password: this.password,
                confirm_password: this.confirm_password,
            };

            if (dados.password !== dados.confirm_password) {
                 M.toast({
                    html: 'Senha de confirmação não confere',
                    displayLength: 5000,
                    classes: 'red darken-1'
                });
                return;
            }

            if (this.id) {
                this.$http.put(this.$urlAPI + 'usuario', dados)
                    .then(resp => {
                        M.toast({
                            html: resp.data.msg,
                            displayLength: 5000,
                            classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                        });
                        this.$router.push('/pesquisa-usuario');
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

            this.$http.post(this.$urlAPI + 'usuario', dados)
                .then(resp => {
                    M.toast({
                        html: resp.data.msg,
                        displayLength: 5000,
                        classes: ((resp.data.status == true) ? 'green darken-1' : 'red darken-1')
                    });
                    this.$router.push('/pesquisa-usuario');
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
