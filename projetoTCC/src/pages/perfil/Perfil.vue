<template>
    <site-template>

        <span slot="menuesquerdo">
            <img :src="usuario.imagem" class="responsive-img">
        </span>

        <span slot="principal">
            <h2>Perfil</h2>
            <input type="text" placeholder="Nome" v-model="name">
            <input type="text" placeholder="E-Mail" v-model="email">
            <div class="file-field input-field">
                <div class="btn">
                    <span>Imagem</span>
                    <input type="file" @change="imgSave">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
            <input type="password" placeholder="Senha" v-model="password">
            <input type="password" placeholder="Confirme sua senha" v-model="password_confirmation">
            <button class="btn" @click="perfil">Atualizar</button>
        </span>

    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'

export default {
    name: 'Perfil',
    components: {
        SiteTemplate
    },
    data () {
        return {
            usuario: false,
            name: '',
            email: '',
            imagem: '',
            password: '',
            password_confirmation: ''
        }
    },
    created() {
        let sessionUser = this.$store.getters.getUsuario;
        if (sessionUser) {
            this.usuario = this.$store.getters.getUsuario;
            this.name = this.usuario.name;
            this.email = this.usuario.email;
        }
    },
    methods: {
        imgSave(e) {
            let arquivo = e.target.files || e.dataTransfer.files; // navigator || arrasta e solta

            if (!arquivo.length) {
                return;
            }

            let reader = new FileReader();
            reader.onloadend = e => {
                this.imagem = e.target.result;
            }
            reader.readAsDataURL(arquivo[0]);
        },
        perfil() {
            this.$http.put(this.$urlAPI + 'perfil', {
                name: this.name,
                email: this.email,
                imagem: this.imagem,
                password: this.password,
                password_confirmation: this.password_confirmation
            }, {'headers': {authorization: 'Bearer ' + this.$store.getters.getToken}})
                .then(resp => {
                    if (resp.data.status) {
                        this.$store.commit('setUsuario', resp.data.usuario);
                        this.usuario = resp.data.usuario;
                        sessionStorage.setItem('usuario', JSON.stringify(this.usuario));
                        alert('Atualizado com sucesso');
                    } else if  (resp.data.status == false && resp.data.validacao) {
                        let erros = '';
                        for (let erro of Object.values(resp.data.erros)) {
                            erros += erro + "\n";
                        }
                       alert(erros);
                    }
                })
                .catch(e => {
                    console.log(e);
                    alert('Tente novamente mais tarde');
            })
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
