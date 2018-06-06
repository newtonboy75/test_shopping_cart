<template>
  <div class="main-container">
  <div v-if="this.$store.state.cartItems.length ===0">
    There is no item in your cart.
  </div>
  <div v-else>
  <div id="demo"></div>
    <div class="mx-auto border-bottom">
      <div class="row  cart-header">
        <div class="col-sm-3"></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3 font-weight-bold text-center">Quantity</div>
        <div class="col-sm-3 font-weight-bold text-right">Total&nbsp;&nbsp;&nbsp;&nbsp;</div>
      </div>
    </div>
    <div class="mx-auto">
      <ul class="cart-holder list-group border-bottom-0">
        <li class="list-group-item border-top-0 border-left-0 border-right-0">
          <div class="row">
            <div class="col-sm-3 col-md-3"><img class="mx-auto cart-item-img" src="@/assets/img/newton_apple.jpg"></div>
            <div class="col-sm-3 col-md-3 font-weight-bold text-center"><div class="valign-text">Newton's Apple</div></div>
            <div class="col-sm-3 col-md-3"><div class="valign-text text-center">3</div></div>
            <div class="col-sm-3 col-md-3"><div class="valign-text text-right">$45.00</div></div>
          </div>
        </li>
        <div class="row subtotal">
          <div class="col"><div class="float-right">Sub Total: <span class="font-weight-bold">$135.00</span></div></div>
        </div>
        <div class="row checkout">
          <div class="col"><div class="float-right"><button class="btn">Checkout</button></div></div>
        </div>
      </ul>
    </div>
  </div>
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
    loadCartItems(){
      document.getElementById("demo").innerHTML = '';
      var x = "";
      var myObj = Cookies.get();
      for (x in myObj) {
        document.getElementById("demo").innerHTML += myObj[x];
      }
    },
    ...mapMutations([
     'addUser'
    ])
  },
  mounted(){
    document.getElementById("demo").innerHTML = '';
    var x = "";
    var myObj = Cookies.get();
    for (x in myObj) {
      document.getElementById("demo").innerHTML += myObj[x];
    }
  }
}
</script>
<style scoped>
.cart-holder{
  min-height:300px;
}
.cart-header{
  margin-bottom:10px;
}
.cart-item-img{
  width:100px;
}
.valign-text{
position: relative;
  top: 50%;
  transform: translateY(-50%);
}
.subtotal{
  margin-top:10px;
}
.checkout{
  margin-top:30px;
}
</style>
