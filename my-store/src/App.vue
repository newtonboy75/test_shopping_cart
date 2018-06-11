<template>
  <div id="app">
  <nav class="navbar">
  <div class="logo-holder center-block"><a href="/" @click="goToCart"><img src="@/assets/newton_logo.png"></a></div>
  <div class="user-cart-holder center-block">
    <ul class="float-right list-inline  user-links">
      <li class="nav-item nav-link">
      <span v-if="(this.$store.state.loggedUser.length === 0)" class="nav-item"><router-link to="/login">Login</router-link></span>
      <span class="text-capitalize" v-else>Hello <router-link to="/admin">{{this.$store.state.loggedUser[0].user}}</router-link></span>
        <span v-if="(this.$store.state.loggedUser.length !== 0)"> (<a href="#" @click="logOut()">logout</a>) - Current Store Balance: ${{(this.$store.state.loggedUser.length === 0 ? "0" : this.$store.state.loggedUser[0].balance)}}</span>
      </li>
      <li class="nav-item  nav-link">
        <router-link to="/cart">Cart (<span> {{this.$store.state.cartItemCount > 0 ? this.$store.state.cartItemCount : " 0"}} {{( this.$store.state.cartItemCount > 0 ? " items" : " item")}} </span>)</router-link>
      </li>
          <div v-if="this.$store.state.info !==''" class="alert alert-success info">{{this.$store.state.info}}</div>
          <div v-if="this.$store.state.warning !=''" class="alert alert-warning cart-warning info">
            {{this.$store.state.warning}}
          </div>
    </ul>
  </div>
</nav>

<div id="demo"></div>
    <router-view :key="$route.fullPath"/>
    <div class="footer">&copy; 2018 Newton's Store</div>
  </div>
</template>

<script>
import axios from 'axios'
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
    cartItemCount: function (){
      return this.$store.state.cartItemCount;
    }
  },
  methods: {

    goToCart(){
      location.reload();
    },
    logOut(){
      this.$store.commit('removeUser');
      location.reload();
    },
    ...mapMutations([
     'addUser', 'removeUser'
    ]),
  },
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
    width:85%;
    margin-top:20px;
    margin-left:auto;
    margin-right:auto;
  }
  .user{text-transform: capitalize;}
  .product-grid {
      text-align: center;
      margin-bottom: 30px;
  }
  .grid-images {
    width:240px;
    height: 240px;
    min-width: 180px;
    min-height: 180px;
    margin-bottom:20px;
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
    width:270px;
  }
  .user-cart-holder{
     width:87%;
     margin-top:10px;
     margin-bottom: 10px;
     clear:both;
     text-align: center;
     font-size:13px;
  }

  .user-links li{
  float:left;
  }

  .ratings .checked{
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

  .ratings span {
    color: #c5c5c5;
  }

  .ratings:hover span {
    cursor: pointer;
    color: orange;
  }

  .ratings span:hover ~ span {
    color: #c5c5c5;
  }

  .info{
  max-width:400px;
    position: absolute;
    margin-top: 42px;
    margin-left:auto;
    margin-right:auto;
  }

</style>
