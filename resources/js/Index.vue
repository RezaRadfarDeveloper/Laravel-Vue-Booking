<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="navbar-nav">
                <router-link class="nav-link" :to="{name: 'home'}">home</router-link>
                <router-link class="btn nav-button" :to="{name: 'basket'}">
                    Basket <span v-if="itemsInBasket" class="badge bg-secondary">{{itemsInBasket}}</span>
                </router-link>
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
        lastSearchComputed: 'lastSearch'
        }),
        ...mapGetters({
            itemsInBasket: 'itemsInBasket'
        })
    }
}
</script>

<style scoped>

</style>
