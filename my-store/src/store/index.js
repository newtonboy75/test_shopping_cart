import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from "vuex-persistedstate"
import * as Cookies from "js-cookie"

Vue.use(Vuex)

export default new Vuex.Store(
  {
    state: {
      cartItems: [],
      loggedUser: [],
      cartItemCount: '',
      info: '',
      warning: ''
    },
    mutations: {
      addCart(state, cartItem) {

          var found = state.cartItems.filter(
            function (x){
              if(x.id == cartItem['id']){
                x.quantity +=1;
                //console.log("found " + cartItem["name"] + " with " + x.quantity);
                return true;
              }else{
                return false;
              }
            }
          );

          if(found.length === 0){
            cartItem['quantity'] = 1;
            state.cartItems.push(cartItem);
          }

          var i=0;
          var itemQuantity = 0;
          var num=0;
          var itemInCart = state.cartItems;
          for(i=0; i<itemInCart.length; i++){
            num = itemInCart[i].quantity;
            itemQuantity += num;
          }
          state.cartItemCount = Number(itemQuantity.toString());
          //console.log(found);
          //console.log(state.cartItems);
          state.info = "Item added to cart"
          setTimeout(function() {
            state.info = ""
          }, 6000);
          return;
      },

      removeCart(state, cartItem) {
        state.cartItems = state.cartItems.filter(item => item !== cartItem);
        var i=0;
        var itemQuantity = 0;
        var num=0;
        var itemInCart = state.cartItems;
        for(i=0; i<itemInCart.length; i++){
          num = itemInCart[i].quantity;
          itemQuantity += num;
        }
        state.cartItemCount = Number(itemQuantity.toString());
        //console.log(state.cartItems);
        state.info = "Item removed from cart";
        setTimeout(function() {
          state.info = ""
        }, 6000);

        return;
      },

      addUser(state, user){
        state.loggedUser.push(user);
      },

      removeUser(state, user){
        state.loggedUser = [];
      },

      reset(state, cartItem){
        state.cartItems = undefined;
        state.cartItemCount = '';
      },

      clearWarning(state, warning){
        setTimeout(function() {
          state.warning = "";
          start.info = "";
        }, 6000);
      },

      removeItemInCart(state, cartItem){
        var oldCartItemCount = state.cartItemCount;
        var found = state.cartItems.filter(
          function (x){
            if(x.id == cartItem['id']){
              x.quantity -=1;
              //console.log("found " + cartItem["name"] + " with " + x.quantity);
              return true;
            }else{
              return false;
            }
          }
        );
        state.cartItemCount = Number((oldCartItemCount - 1));
        state.info = "Item removed from cart"
        setTimeout(function() {
          state.info = ""
        }, 6000);
      }
    },
    getters: {
    },
    actions: {
    },
    plugins: [createPersistedState({
      storage: {
        getItem: key => Cookies.get(key),
        setItem: (key, value) => Cookies.set(key, value, { expires: 3, secure: false }),
        removeItem: key => Cookies.remove(key)
      }
    })
    ]
  }
)
