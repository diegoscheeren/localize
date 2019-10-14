<template>

  <site-template>

    <span slot="menuesquerdo">
        <img src="https://www.designerd.com.br/wp-content/uploads/2013/06/criar-rede-social.png"
            class="responsive-img">
    </span>

    <span slot="principal">

      <h2>Cadastro</h2>

      <input type="text" placeholder="Nome" v-model="name">
      <input type="text" placeholder="E-mail" v-model="email">
      <input type="password" placeholder="Senha" v-model="password">
      <input type="password" placeholder="Confirme sua Senha" v-model="password_confirmation">
      <button class="btn" v-on:click="cadastro()">Enviar</button>
      <router-link class="btn orange" to="/login">Já tenho conta</router-link>

    </span>

  </site-template>

</template>

<script>
import LoginTemplate from '@/templates/LoginTemplate'


export default {
  name: 'Registro',
  data () {
    return {
      name:'',
      email:'',
      password:'',
      password_confirmation:''
    }
  },
  components:{
    LoginTemplate
  },
  methods:{
    cadastro(){
      this.$http.post(this.$urlAPI + 'cadastro', {
        name: this.name,
        email: this.email,
        password:this.password,
        password_confirmation:this.password_confirmation
      })
      .then(response => {
        if (response.data.status) {
          console.log('Cadastro realizado com sucesso')
          this.$store.commit('setUsuario',response.data.usuario);
          sessionStorage.setItem('usuario',JSON.stringify(response.data.usuario));
          this.$router.push('/');
        }else if(response.data.status == false && response.data.validacao){
          // erros de validação
          console.log('erros de validação')
          let erros = '';
          for(let erro of Object.values(response.data.erros)){
            erros += erro +" ";
          }
          alert(erros);

        }else{
          alert('Erro no cadastro! tente novamente mais tarde.');
        }
      })
      .catch(e => {
        console.log(e)
        alert("Erro! Tente novamente mais tarde!");
      })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
