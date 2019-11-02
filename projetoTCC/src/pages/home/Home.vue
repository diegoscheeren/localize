<template>
    <site-template>
        <span slot="principal">
            <!-- <div class="container"> -->
                <div class="row">
                    <div class="col s12 m6 l4">
                        <div class="card blue white-text">
                            <div class="card-content ">
                                <div class="row">
                                    <div class="col s4 m5">
                                        <div v-if="load" class="preloader-wrapper small active">
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
                                        <span v-if="!load" class="card-title"
                                            style="font-size: 45px; font-weight: bold">{{this.clienteHoje}}</span>
                                    </div>
                                    <div class="col s8 m5">
                                        <i class="material-icons" style="font-size: 90px; color: #2169f3;">people</i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action blue darken-1" style="font-size: 20px;">
                                Clientes hoje
                            </div>
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="card yellow darken-2 white-text">
                            <div class="card-content ">
                                <div class="row">
                                    <div class="col s4 m5">
                                        <div v-if="load" class="preloader-wrapper small active">
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
                                        <span v-if="!load" class="card-title"
                                            style="font-size: 45px; font-weight: bold">{{this.comandasAbertas}}</span>
                                    </div>
                                    <div class="col s8 m5">
                                        <i class="material-icons" style="font-size: 90px; color: #db8b24;">note_add</i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action yellow darken-3" style="font-size: 20px;">
                                Comandas abertas
                            </div>
                        </div>
                    </div>

                    <div class="col s12 m6 l4">
                        <div class="card light-green accent-4 white-text">
                            <div class="card-content ">
                                <div class="row">
                                    <div class="col s4 m5">
                                        <div v-if="load" class="preloader-wrapper small active">
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
                                        <span v-if="!load" class="card-title"
                                            style="font-size: 45px; font-weight: bold">{{this.vendasMes}}</span>
                                    </div>
                                    <div class="col s8 m5">
                                        <i class="material-icons" style="font-size: 90px; color: #47a128;">add_shopping_cart</i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action" style="font-size: 20px; background: #57ce57">
                                Vendas no mês
                            </div>
                        </div>
                    </div>

                    <div class="col s12 m6 l12">
                        <div class="card red darken-2 white-text">
                            <div class="card-content ">
                                <div class="row center">
                                     <table id="table">
                                        <thead>
                                            <tr>
                                                <th>Posição</th>
                                                <th>Item</th>
                                                <th>Vendas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="i in maisVendidos" :key="i.id">
                                                <td>{{i.posicao}}</td>
                                                <td>{{i.descricao}}</td>
                                                <td>{{i.quantidade}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-if="load" class="preloader-wrapper small active" style="margin-top: 25px">
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
                            <div class="card-action" style="font-size: 20px;">
                                Mais vendidos
                            </div>
                        </div>
                    </div>
                </div>
            <!-- </div> -->
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'
import CardDetalheVue from '@/components/localize/CardDetalheVue'
import CardConteudoVue from '@/components/localize/CardConteudoVue'

export default {
    name: 'Home',
    components: {
        SiteTemplate,
        CardDetalheVue,
        CardConteudoVue,
    },
    data () {
        return {
            usuario: false,
            load: false,
            vendasMes: 0,
            clienteHoje: 0,
            maisVendidos: {},
            comandasAbertas: 0
        }
    },
    created() {
        let sessionUser = sessionStorage.getItem('usuario');
        if (sessionUser) {
            this.usuario = JSON.parse(sessionUser);
            this.name = this.usuario.name;
            this.email = this.usuario.email;
        }
        this.setCardInfo();
    },
    methods: {
        setCardInfo() {
            this.load = true;
            this.$http.get(this.$urlAPI + 'dashboard')
                .then(resp => {
                    let dados = resp.data.data;

                    this.vendasMes = dados.vendasMes;
                    this.clienteHoje = dados.clientesHoje;
                    this.comandasAbertas = dados.comandasAbertas;
                    this.maisVendidos = dados.maisVendidos;

                    this.load = false;
                });
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
