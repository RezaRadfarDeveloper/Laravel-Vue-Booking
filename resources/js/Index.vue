<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="navbar-nav">
                <router-link class="nav-link" :to="{name: 'home'}">home</router-link>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name: 'basket'}">
                            Basket <span v-if="itemsInBasket" class="badge bg-secondary">{{itemsInBasket}}</span>
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="!isLoggedIn">
                        <router-link class="nav-link" :to="{name: 'register'}">
                           Register
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="!isLoggedIn">
                        <router-link class="nav-link" :to="{name: 'login'}">
                            Login
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="isLoggedIn">
                        <a class="nav-link" href="#" @click.prevent="logout">
                            Logout
                        </a>
                    </li>
                </ul>
<!--                <router-link class="nav-link" :to="{name: 'second'}">second</router-link>-->
            </div>
        </nav>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import {mapState, mapGetters} from 'vuex';
export default {
    name: "index",
    data() {
        return {
            lastSearch: this.$store.state.lastSearch
        }
    },
    computed: {
        ...mapState({
        lastSearchComputed: 'lastSearch',
            isLoggedIn: 'isLoggedIn'
        }),
        ...mapGetters({
            itemsInBasket: 'itemsInBasket'
        })
    },
    methods:{
        async logout() {
            try{
               await axios.post('/logout');
                this.$store.dispatch('logOut');
            }catch (error){
                this.$store.dispatch('logOut');
            }
        }
    }
}
</script>

<style scoped>

</style>
