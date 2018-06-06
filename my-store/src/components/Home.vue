<template>
  <div class="main-container">
  <div class="row">

  <div class="product-grid col-sm-4"  v-for="item in items">
  <div class="center-block"><img class="grid-images" :src="getSrc(item.product_image)""></div>
  <div class="font-weight-bold">{{item.name}}</div>
  <div>
  <span class="rate-star" v-bind:class="{ checked: item.rating >= 1}">&starf;</span>
  <span class="rate-star" v-bind:class="{ checked: item.rating >= 2}">&starf;</span>
  <span class="rate-star" v-bind:class="{ checked: item.rating >= 3}">&starf;</span>
  <span class="rate-star" v-bind:class="{ checked: item.rating >=  4}">&starf;</span>
  <span class="rate-star" v-bind:class="{ checked: item.rating >= 5}">&starf;</span>
  </div>
  <div>${{item.unit_price}}</div>
  <button class="btn buy-btn" @click="addCart(item)">Add to Cart</button>
  </div>
</div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapMutations } from 'vuex'

export default {
  name: 'Home',
  data () {
    return {
      items: []
    }
  },
  mounted(){
  axios.get('http://localhost/test_shopping_cart/Main.php?dest=products')
  .then(response => {
  console.log("items" +response.data);
  this.items = response.data;
  })
  .catch(function (error) {
    console.log("items" + error);
  });
  },
  methods: {
    getSrc(name) {
         var images = require.context('../assets/img/', false, /\.jpg$/);
         return images('./' + name)
     },
     ...mapMutations([
      'addCart'
    ]),
    addCartItem(){
      //this.$store.commit('addCart');
      //this.addCart(this.item)
      this.$store.commit('addCart');
    }
  }
}
</script>
