<template>
  <div id="app">
  <nav class="navbar">
  <div class="logo-holder center-block"><img src="@/assets/newton_logo.png"></div>
  <div class="user-cart-holder center-block">
    <div class="float-right">
        <a class="user" href="#" @click="getUser">{{(this.$store.state.loggedUser.length === 0 ? "Login" : this.$store.state.loggedUser[0].user)}}</a> -
        <span>Current Balance: ${{(this.$store.state.loggedUser.length === 0 ? "0" : this.$store.state.loggedUser[0].balance)}}</span> &nbsp;&nbsp;&nbsp;&nbsp;
        <span @click="showCartItems()">{{( itemCounts > 0 ? " items" : " item")}} {{itemCounts}}</span>
        <router-link to="/cart">Checkout</router-link>
    </div>
  </div>
</nav>
<!--
<button @click="loadItems">test</button>
-->
    <router-view/>
    <div class="footer">&copy; 2018 Newton's Store</div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import { mapActions } from 'vuex'
import { mapMutations } from 'vuex'
import * as Cookies from "js-cookie";

export default {
  name: 'App',
  data () {
    return {
    user: [],
    cartItems: [],
    }
  },
  computed: {
    itemCounts(){
      return this.$store.state.cartItems.length
    },
  },
  methods: {
    loadItems(){
      document.getElementById("demo").innerHTML = '';
      var x = "";
      var myObj = Cookies.get();
      for (x in myObj) {
        document.getElementById("demo").innerHTML += myObj[x];
        }
    },
    ...mapMutations([
     'addUser'
    ]),
    getUser(){
    if(this.$store.state.loggedUser.length === 0){

      axios.get('http://localhost/test_shopping_cart/Main.php?dest=user&username=newton&password=admin')
      .then(response => {
      console.log("users " +response.data.user);

        this.addUser(this.user = response.data);
        this.$store.commit('addUser');

      })
      .catch(function (error) {
        console.log("user" + error);
      });
      }

    }
  },
  mounted(){



  }


}
</script>
<style>
 @import url('https://fonts.googleapis.com/css?family=Open+Sans');

#app {
  font-family: 'Open Sans', 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  font-size: 13px;
}
  .main-container{
    margin-top:20px;
    margin-left:100px;
    margin-right:100px;
  }
  .user{text-transform: capitalize;}
  .product-grid {
      text-align: center;
      margin-bottom: 30px;
  }
  .grid-images {
    width:254px;
    height: 254px;
    min-width: 200px;
    min-height: 200px;
    margin-bottom:10px;
    background: #aaa;

  }
  .buy-btn{
      min-width: 100px;
      margin-top: 5px;
      background: #3ca88b;
      color: #ffffff;
      font-size: 12px;
      font-weight:bold;
  }
  .buy-btn:hover{
    opacity: 0.8;
  }
  .logo-holder{
    margin-left: auto;
    margin-right: auto;
  }
  .logo-holder img{
    width:280px;
  }
  .user-cart-holder{
     width:87%;
     margin-top:20px;
     margin-bottom: 30px;
     clear:both;
     text-align: center;
     font-size:13px;
  }
  .checked{
    color:orange;
  }
  .rate-star{
    font-size: 30px;
  }

  .footer{
    text-align:center;
    width:300px;
    margin-top:30px;
    margin-bottom:20px;
    margin-left:auto;
    margin-right:auto;
  }
</style>
