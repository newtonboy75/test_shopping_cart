<template>
  <div class="main-container container">
  <h5>Order Summary</h5>
    <div class="row main-row">
      <div class="col-xs-9">
      <ul class="cart-holder list-unstyled list-group">
        <li class="list-group-item border-top-0 border-left-0 border-top-0 border-right-0" v-for="(cartItem, index) in this.$store.state.cartItems" :key="index">
          <div class="row">
            <div class="col-4">
            <div class="float-left"><img class="mx-auto pull-left cart-item-img img-fluid" :src="getSrc(cartItem.product_image)"></div>
            </div>
            <div class="col-4 itemname">{{cartItem.name}}</div>
            <div class="col-2">x {{cartItem.quantity}}</div>
            <div class="col-2">&nbsp;&nbsp;&nbsp;${{(parseFloat(cartItem.unit_price) * parseInt(cartItem.quantity)).toFixed(2)}}</div>
          </div>
        </li>
        <div class="row subtotal"><div class="col-10"><span class="float-right">Sub Total:</span></div><div class="col-2">
        <span v-if="subTotal == ''">{{computeSubtotal}}</span>
        <span v-else id="subtotal" class="font-weight-bold">${{subTotal}}</span></div></div>
      </ul>

      </div>
      <div class="col-xs-3">
      <div class="pay-section">
        <div v-if="this.$store.state.loggedUser[0].balance" class="store-balance">
        <p><span class="font-weight-bold">Current Store Balance</span></p>
        <span class="balance-amount">${{this.$store.state.loggedUser[0].balance}}</span>
        </div>
        <p><span class="font-weight-bold">Shipping Method:</span></p>

          <div><input class="shipping-option" type="radio" name="options" :value="0.00" @change="addShipping($event)">Pick Up (Free)</div>
          <div><input class="shipping-option" type="radio" name="options" :value="5.00" @change="addShipping($event)">UPS ($5.00)</div>

      </div>
      <div class="center-block"><button class="btn pay-button" @click="processPreCheckOut()">Pay</button></div>
      <router-link to="/cart" class="backlink"><- Back to Cart</router-link>
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
    shippingOption: '',
    newBalance: ''
    }
  },
  mounted() {
    this.clearWarning();
  },
  computed: {
    computeSubtotal: function(){
      var sum = 0;
      this.$store.state.cartItems.forEach(item => {
        sum += (parseFloat(item.unit_price)*parseFloat(item.quantity));
        //console.log(element.unit_price)
      });
      this.subTotal = sum.toFixed(2);
      this.cartWarning = '';
    },

  },
  methods: {
    addShipping($event){
    var sum = 0;
    this.$store.state.cartItems.forEach(item => {
      sum += (parseFloat(item.unit_price)*parseFloat(item.quantity));
      //console.log(element.unit_price)
    });

    let subtotal = (parseFloat(sum) + parseFloat(event.target.value));
    //console.log(subtotal);
    this.subTotal = subtotal.toFixed(2);
    this.cartWarning = '';
    this.shippingOption = '1';
    },
    processPreCheckOut(){
      if(this.shippingOption == ''){
        this.$store.state.warning = "You must choose a shipping method.";
        this.$store.commit('clearWarning');
      }else if(this.subTotal > this.$store.state.loggedUser[0].balance){
          this.$store.state.warning = "Your balance is insufficient to make this purchase. Please load more balance or change your payment option.";
          this.$store.commit('clearWarning');
      }else{
        this.processCheckOut();
      }
    },
    processCheckOut(){
      //check if customer is logged in (**should be using a middleware but make it simple for now)
      if(this.$store.state.loggedUser.length === 0){
        this.$router.push('/login');
        this.$store.state.warning = "Please login with your username and password";
      }else{
        //console.log(this.$store.state.loggedUser[0].customer_id);
        var checkOutItems = new Object();
        var checkOutItemsArray = new Array();
        checkOutItems.customer_id = this.$store.state.loggedUser[0].customer_id;
        checkOutItems.new_balance = ((this.$store.state.loggedUser[0].balance) - (this.subTotal)).toFixed(2);
        this.newBalance = ((this.$store.state.loggedUser[0].balance) - (this.subTotal)).toFixed(2);
        this.$store.state.cartItems.forEach(item => {
          checkOutItemsArray.push({'item_id': item.id, 'quantity': item.quantity, 'total': (item.unit_price*item.quantity).toFixed(2)});
        });
        checkOutItems.items = checkOutItemsArray;
        this.sendCheckOut(checkOutItems);
        //console.log(new_balance);
      }
    },
    //send checkout to server
    sendCheckOut(c){
    //console.log(c)
    let app = this;
    axios.post('http://newtonboy.cba.pl/main.php?dest=cart&cart_items='+JSON.stringify(c))
      .then(function(response){
        console.log(response.data)
        if(response.data > 0){
          app.resetStore();
          //redirect to user page
          app.$router.push('/admin');
          app.$store.state.info="Thank you. We will notify you about the status of your order."
          app.clearWarning();
        }
      });
    },
    clearWaning(){
      this.$store.commit('clearWarning');
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
.main-row{
  min-height:350px;
}

.cart-holder{
  margin-top:20px;
}
.cart-item-img{
  width:60px;
}



.subtotal{
  margin-top:20px;
}

.store-balance{
  margin-bottom: 30px;
}

.pay-section{
  margin-left:80px;
  margin-top: 30px;
}

.balance-amount{
  font-size:20px;
}
.shipping-option{
  margin-right:10px;
}

.pay-button{
  width:50%;
  margin-top:40px;
  margin-bottom:30px;
  margin-left: 80px;
}

.cart-warning{
  width:90%;
  margin-top:20px;
  margin-left:auto;
  margin-right:auto;
}

.backlink{
  margin-left: 80px;
}

.itemname{
  width: 300px !important;
}

@media only screen
and (min-device-width : 320px)
and (max-device-width : 480px) {
  .main-container{
    width: 100% !important;
    margin-left: 0px !important;
    margin-right: 0px !important;
  }
  .itemname{
    width: 100px !important;
  }
}

@media only screen
and (min-width : 1224px) {
  .main-container{
    width:70%;
  }



}
</style>
