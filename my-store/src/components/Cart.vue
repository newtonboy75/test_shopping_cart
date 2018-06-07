<template>
  <div class="main-container">
  <div v-if="this.$store.state.cartItems.length ===0">
    There is no item in your cart.
  </div>
  <div v-else>
  <div id="demo"></div>
    <div class="mx-auto border-bottom">
      <div class="row  cart-header">
        <div class="col-sm-4"></div>
        <div class="col-sm-4 font-weight-bold text-center">Quantity</div>
        <div class="col-sm-4 font-weight-bold text-right">Total&nbsp;&nbsp;&nbsp;&nbsp;</div>
      </div>
    </div>
    <div class="mx-auto">
      <ul class="cart-holder list-group border-bottom-0">
        <li class="list-group-item border-top-0 border-left-0 border-right-0" v-for="(cartItem, index) in this.$store.state.cartItems" :key="index">
          <div class="row">
            <div class="col-sm-4 col-md-4"><img class="mx-auto pull-left cart-item-img" :src="getSrc(cartItem.product_image)"><span id="product-name">{{cartItem.name}}</span></div>
            <div class="col-sm-4 col-md-4"><div class="valign-text text-center">
              <span class="glyphicon glyphicon-triangle-left"></span>
                <input class="text-center form-control w-50 mx-auto" type="text" v-bind:value="cartItem.unit_price">
              <span class="glyphicon glyphicon-triangle-right"></span>
            </div></div>
            <div class="col-sm-4 col-md-4"><div class="valign-text text-right">${{cartItem.unit_price}}</div></div>
          </div>
        </li>
        <div class="row subtotal">
          <div class="col"><div class="float-right">Sub Total: <span id="subtotal" class="font-weight-bold">{{computeSubtotal}}</span></div></div>
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
    subTotal: ''
    }
  },
  computed: {
    itemCounts(){
      return this.$store.state.cartItems.length
    },
    unique(){},
    computeSubtotal: function(){
    var sum = 0;
    this.$store.state.cartItems.forEach(element => {
      sum += parseFloat(element.unit_price);
      //console.log(element.unit_price)
    });
    return "$"+sum;
    //console.log(sum);
    },

  },
  methods: {

    getSrc(name) {
         var images = require.context('../assets/img/', false, /\.jpg$/);
         return images('./' + name)
     },
    ...mapMutations([
     'addUser'
    ])
  },
  mounted(){
  //console.log(this.$store.state.cartItems);
  }
}
</script>
<style scoped>
@import url("//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css")

.cart-holder{
  min-height:300px;
}
.cart-header{
  margin-bottom:10px;
}
.cart-item-img{
  width:100px;
  margin-right:20px;
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
.input-price{
  width: 50px !important;
  text-align: center;
  font-size: 13px;
}
#product-name{
  display: inline-bock !important;
  width:50px;
  max-width:100px;
  max-height:100px;
}
</style>
