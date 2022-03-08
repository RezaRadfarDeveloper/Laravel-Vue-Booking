<template>
<div class="row">
    <div class="col-md-8 pb-4">
        <div class="card">
            <div class="card-body">
                <div v-if="!loading">
                    <h2>
                        {{bookable.title}}
                    </h2>
                    <hr>
                    <article>
                        {{bookable.description}}
                    </article>
                </div>
                <div v-else> Loading ...</div>

            </div>
        </div>
        <ReviewList :bookable-id="this.$route.params.id"></ReviewList>
    </div>
    <div class="col-md-4 pb-4">
        <Availability :bookable-id="this.$route.params.id" @availability="checkPrice($event)" class="mb-4"></Availability>
        <transition name="fade">
        <PriceBreakdown v-if="price" :price="price"></PriceBreakdown>
        </transition>
        <transition name="fade">
            <button class="btn btn-outline-secondary w-100 mt-2" v-if="price" :disabled="inBasketAlready" @click="addToBasket">Book Now!</button>
        </transition>
        <button class="btn btn-outline-secondary w-100 mt-2" v-if="inBasketAlready" @click="removeFromBasket">Remove from basket</button>
        <div v-if="inBasketAlready" class="text-muted mt-3 warning">You have already added the product. To change the date first remove previous one.</div>
    </div>
</div>
</template>

<script>
import Availability from "./Availability";
import ReviewList from "./ReviewList";
import PriceBreakdown from "./PriceBreakdown";

import {mapState} from "vuex";

export default {

    name: "Bookable",
    components: {
        Availability,
        ReviewList,
        PriceBreakdown
    },
    data() {
        return {
            bookable: null,
            loading: false,
            price: null
        }
    },
    created() {
        this.loading = true;
        this.price = null;
        axios.get(`/api/bookables/${this.$route.params.id}`).then(response => {
            this.loading = false;
            this.bookable = response.data.data
        })
    },
    computed: {
        ...mapState({
            lastSearch: "lastSearch"
        }),
        inBasketAlready() {
            if( this.bookable === null) {
                        return false;
                    }
            return this.$store.getters.inBasketAlready(this.bookable.id);
        }
    } ,
    methods: {

       async checkPrice(availability) {

            if(!availability) {
                this.price = null;
                return;
            }
            try {
                this.price = (await axios.get(`/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`)).data.data
            } catch(err) {
                this.price = null;
            }


        },
        addToBasket() {
           this.$store.dispatch('addToBasket',{
               bookable: this.bookable,
               dates: this.lastSearch,
               price: this.price
           })
        },

        removeFromBasket() {
           this.$store.dispatch('removeFromBasket',this.bookable.id);
        }
    }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 1s;
}

.fade-enter, .fade-leave-to {
    opacity: 0;
}
.warning {
    font-size: 0.7rem;
    color: #661a2121;
}
</style>
