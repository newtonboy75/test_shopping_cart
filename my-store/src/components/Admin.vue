<template>
  <div class="main-container container">

  <h5>User Profile</h5>
    <div class="row main-row">
      <div class="col-xs-6">
        <div class="row"><ul class="profile-holder">
          <li class="font-weight-bold"><div class=" fullname">{{this.$store.state.loggedUser[0].full_name}}</div></li>
          <li>{{this.$store.state.loggedUser[0].email}}</li>
          <li><div class="address">{{this.$store.state.loggedUser[0].address}}</div></li>
          <li><span class="font-weight-bold">Current Balance:</span> ${{this.$store.state.loggedUser[0].balance}}</li>
          <li><span class="font-weight-bold">Previous Balance:</span> ${{this.$store.state.loggedUser[0].previous_balance}}</li>
        </ul></div>
      </div>
      <div class="col-xs-6">
        <div class="row order-info">

          <ul  class="profile-holder">

            <li class="orders">
            <p class="font-weight-bold">Recent Purchases</p>



              <div class="row">
              <div class="col-6"><p class="font-weight-bold">Order ID</p></div><div class="col-3"><p class="font-weight-bold">Date</p></div><div class="col-3"><p class="font-weight-bold">Status</p></div>
                <div v-for="(order, index) in this.$store.state.loggedUser[0].orders" :key="index">
                  <div>
                    <div class="row">
                      <div class="col-6">{{order[0]}}</div><div class="col-3">{{order[1]}}</div><div class="col-3">{{order[2]}}</div>
                    </div>
                  </div>
                </div>
                </div>
            </li>
          </ul>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios'
import { mapMutations } from 'vuex'
import * as Cookies from "js-cookie";

export default {
  name: 'Home',
  data () {
    return {
      user: [],
    }
  },
  mounted(){
  let app = this;
    axios.get("http://newtonboy.cba.pl/main.php?dest=info&user_info_id="+app.$store.state.loggedUser[0].customer_id)
    .then( response => {
    console.log(response.data);
      if(response.data == "0"){
        console.log("errro");
      }else{
        //console.log($user);
        this.$store.commit('removeUser');
        this.addUser(this.user = response.data);

        this.$store.commit('addUser');

      }
    }).catch((error) => {
        app.responseError();
    });

    //console.log(this.$store.state.loggedUser[0].orders);

  },
  methods: {
    getSrc(name) {
         var images = require.context('../assets/img/', false, /\.jpg$/);
         return images('./' + name)
     },
     ...mapMutations([
      'addUser', 'removeUser'
    ]),
    addCartItem(){
      this.$store.commit('addCart');
      this.currentItemCount();
    }
  }
}
</script>
<style scoped>
.main-row{
  min-height:300px;
}

.cart-holder{
  margin-top:20px;
}

.fullname{
  font-size: 24px;
}
.profile-holder li{
  border:0px !important;
  list-style:none;
  font-size: 14px;
}

.address{
  max-width:400px !important;
  min-height:40px;
  margin-right: 30px;
}

.orders{
  margin-top:30px;
  max-width: 360px;
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
