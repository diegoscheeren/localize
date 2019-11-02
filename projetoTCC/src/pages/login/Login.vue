<template>
    <login-template>
        <span slot="principal">
            <div class="container center">
                <div class="row">
                    <div class="section"></div>
                    <main>
                        <div class="container">
                            <div class="z-depth-3 y-depth-3 x-depth-3 row"
                                style="display: inline-block; padding: 32px 48px 0px 48px;
                                    border: 1px; margin-top: 70px; solid #EEE;">
                                <h2>Login</h2>
                                <div class='row'>
                                    <div class='input-field col s12'>
                                        <i class="material-icons prefix">account_circle</i>
                                        <input id="email" type="email" class="validate" v-model="email"
                                            placeholder=" ">
                                        <label for="email">E-Mail</label>
                                        <span class="helper-text" data-error="E-Mail inválido"></span>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='input-field col m12'>
                                        <i class="material-icons prefix">lock</i>
                                        <input id="pwd" type="password" v-model="password" placeholder=" ">
                                        <label for="pwd">Senha</label>
                                    </div>
                                </div>
                                <br/>
                                <div class='row'>
                                    <button v-if="!load" class="btn col s6 waves-effect z-depth-1 y-depth-1 center"
                                        @click="login()" style="margin-left: 70px;">Entrar
                                    </button>
                                    <div class="preloader-wrapper big active" v-if="load">
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
                        </div>
                    </main>
                </div>
            </div>
        </span>
    </login-template>
</template>

<script>
import LoginTemplate from '@/templates/LoginTemplate'

export default {
    name: 'Login',
    data () {
        return {
            email: 'dscheeren23@gmail.com',
            password: '12345678',
            load: false
        }
    },
    created() {
        M.updateTextFields();
    },
    components: {
        LoginTemplate
    },
    methods: {
        login() {
            this.load = true;
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
                    this.load = false;
                     M.toast({
                        html: erros,
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                } else {
                    this.load = false;
                     M.toast({
                        html: 'Login inválido',
                        displayLength: 5000,
                        classes: 'red darken-1'
                    });
                }
            })
            .catch(e => {
                M.toast({
                    html: 'Erro, tente novamente mais tarde',
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
.container  {
    display: flex;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
}

.container .row {
    margin: 0 auto;
}
</style>
