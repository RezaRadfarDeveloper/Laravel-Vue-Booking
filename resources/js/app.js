import router from './routes';
import vueRouter from "vue-router";
import Vuex from "vuex";
import Index from "./Index";
import moment from "moment";
import StarRating from "./components/shared/components/StarRating";
import FatalError from "./components/shared/components/FatalError";
import ValidationError from "./components/shared/components/ValidationError";
import Success from "./components/shared/components/Success";
import StoreDefinition from "./store";

require('./bootstrap');
window.Vue = require('vue').default;


Vue.component("star-rating", StarRating);
Vue.component("fatal-error", FatalError);
Vue.component('v-errors', ValidationError);
Vue.component('success', Success);
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.use(vueRouter);
Vue.use(Vuex);
Vue.filter("fromNow", function (value){
    return moment(value).fromNow()
});

const store = new Vuex.Store(StoreDefinition);
// const store = new Vuex.Store({
//     state: {
//         count: 0,
//         name: 'john'
//     },
//     mutations: {
//         increment (state) {
//             console.log(state)
//             state.count++
//         },
//         changeName(state, payload) {
//             state.name = payload;
//             console.log(state)
//         }
//     }
// });

window.onload = function (){
const app = new Vue({
    el: '#app',
    router,
    store,
    components:{
         Index
    },
    beforeCreate() {
        this.$store.dispatch('loadStoredState');
    }

});
}
