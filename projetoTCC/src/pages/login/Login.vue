<template>
    <login-template>
            <span slot="principal">
            <h2>Login</h2>
            <div class="row" style="margin-bottom: -20px;">
                <div class="input-field inline">
                    <input id="email" type="email" class="validate" v-model="email">
                    <label for="email">E-Mail</label>
                    <span class="helper-text" data-error="E-Mail inválido"></span>
                </div>
            </div>
            <div class="row">
                <div class="input-field inline">
                    <input id="pwd" type="password" v-model="password">
                    <label for="pwd">Senha</label>
                </div>
            </div>
            <button class="btn" @click="login()">Entrar</button>
            <router-link class="btn orange" to="/registro">Cadastre-se</router-link>
        </span>
  </login-template>
</template>

<script>
import LoginTemplate from '@/templates/LoginTemplate'

export default {
    name: 'Login',
    data () {
        return {
            email: 'diego@gmail.com',
            password: '12345678'
        }
    },
    components: {
        LoginTemplate
    },
    methods: {
        login() {
            this.$http.post(this.$urlAPI + 'login', {
                email: this.email,
                password: this.password
            })
            .then(response => {
                if (response.data.status) {
                    this.$store.commit('setUsuario', response.data.usuario);
                    sessionStorage.setItem('usuario', JSON.stringify(response.data.usuario));
                    this.$router.push('/');
                } else if (response.data.status == false && response.data.validacao) {
                    let erros = '';

                    for (let erro of Object.values(response.data.erros)) {
                        erros += erro + "\n";
                    }
                    alert(erros);
                } else {
                    alert('Login inválido!');
                }
            })
            .catch(e => {
                alert('Erro! Tente novamente mais tarde!');
            })
        }
    }
}
M.updateTextFields();
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
