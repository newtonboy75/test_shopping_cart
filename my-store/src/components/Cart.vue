<template>
  <div class="main-container container">
  <h5>Cart</h5>
  <div v-if="this.$store.state.cartItems.length ===0">
    There is no item in your cart.
  </div>
  <div v-else>
  <div id="demo"></div>
    <div class="mx-auto border-bottom">
      <div class="row  cart-header">
        <div class="col-6"></div>
        <div class="col-4 font-weight-bold text-center mx-auto">Quantity</div>
        <div class="col-2 font-weight-bold text-right mx-auto">Total&nbsp;&nbsp;&nbsp;&nbsp;</div>
      </div>
    </div>
    <div class="mx-auto"">
      <ul class="cart-holder list-unstyled list-group">
        <li class="list-group-item border-top-0 border-left-0 border-top-0 border-right-0" v-for="(cartItem, index) in this.$store.state.cartItems" :key="index">
          <div class="row">

            <div class="col-6">
            <div class="row align-middle valign-text">
              <div class="col-6 pull-left"><div class="float-left"><img class="mx-auto pull-left cart-item-img img-fluid" :src="getSrc(cartItem.product_image)">
              </div>

              </div>
              <div class="col-6 align-middle product-name mx-auto">{{cartItem.name}}
                <div @click="removeFromCart(cartItem)"><br><br>[x] Remove</div>
              </div>
              </div>
            </div>

            <div class="col-6">
            <div class="row align-middle valign-text text-center">
              <div class="col-8"><div class="text-center mx-auto">
                  <input type="number" @input="changeQuantity(cartItem.quantity, cartItem, $event)" style="font-size:13px; width: 60px" class="text-center form-control mx-auto" :value="cartItem.quantity">
              </div></div>
              <div class="col-4"><div class="valign-text text-right">${{(parseFloat(cartItem.unit_price) * parseInt(cartItem.quantity)).toFixed(2)}}</div></div>
            </div>
            </div>

          </div>

        </li>
        <div class="row subtotal">
          <div class="col"><div class="float-right"><span>Sub Total &nbsp;</span> <span id="subtotal" class="font-weight-bold">{{computeSubtotal}}</span></div></div>
        </div>
        <div class="row checkout">
          <div class="col">

          <div class="float-right"><button @click="{{checkOut()}}" class="btn chkout-btn">Checkout</button></div>

          </div>
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
    subTotal: '',
    }
  },
  mounted() {
    this.$store.state.info = '';
    this.$store.state.warning= '';
  },
  computed: {

    computeSubtotal: function(){
      var sum = 0;
      this.$store.state.cartItems.forEach(item => {
        sum += (parseFloat(item.unit_price)*parseFloat(item.quantity));
        //console.log(element.unit_price)
      });
      return "$"+sum.toFixed(2);
    },

  },
  methods: {
    changeQuantity(oldVal, item, $event){

      let newVal = event.target.value;
      let addVal = (newVal-oldVal);

      var i;
      if(newVal > oldVal){
        for(i=0; i<addVal; i++){
          this.addCart(item);
        }
      }else{
        let decreaseVal = (oldVal-newVal);

        for(i=0; i<decreaseVal; i++){
          this.removeItemInCart(item);
        }

      }
    },
    reloadThis(){
      this.$router.go('');
    },
    checkOut(){
    if(this.$store.state.loggedUser.length === 0){
      this.$router.push('/login');
      this.$store.state.warning = "Please login with your username and password.";
      this.$store.commit('clearWarning');
    }else{
      this.$router.push('/checkout');
    }

    },
    getSrc(name) {
         var images = require.context('../assets/img/', false, /\.jpg$/);
         return images('./' + name)
     },
    ...mapMutations([
      'addCart', 'removeCart', 'removeItemInCart', 'reset', 'clearWarning'
    ]),
    //remove the whole product item from cart
    removeFromCart(cartItem){
      //console.log(cartItem);
      this.$store.commit('removeCart', cartItem);
    },
    //increase quantity of product item
    addCartItem(){
      this.$store.commit('addCart');
      //this.currentItemCount();
    },
    //decrease quantity of product item
    removeInCart(){
      this.$store.commit('removeItemInCart');
    },
    resetStore(){
      this.$store.commit('reset');
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
  font-size: 13px !important;
}

.trow{
height:100px;
  margin-top:auto;
  margin-bottom:auto;
}
.triangle-left, .triangle-right{
  font-size:16px;
}

@media only screen
and (min-device-width : 320px)
and (max-device-width : 480px) {
  .main-container{
    width: 100% !important;
    margin-left: 0px !important;
    margin-right: 0px !important;
  }
}

@media only screen
and (min-width : 1224px) {
  .main-container{
    width:70%;
  }
}
</style>
