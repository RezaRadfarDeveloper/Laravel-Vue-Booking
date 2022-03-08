<template>
<div>
    <h6 class="text-uppercase text-secondary"> Check Availability
       <transition name="fade">
           <span class="text-success" v-if="hasAvailability">(AVAILABLE)</span>
           <span class="text-danger" v-if="noAvailability">(NOT AVAILABLE)</span>
       </transition>
    </h6>
    <div class="row dl-flex flex-row">
        <div class="form-group col-md-6">
            <label id="from">From</label>
            <input type="text" name="from"
                   v-model="from"
                   class="form-control form-control-sm"
                   placeholder="Start Date"
                   :class="{'is-invalid': this.errorFor('from')}"
            >
            <v-errors :errors="errorFor('from')"></v-errors>
        </div>
        <div class="form-group col-md-6">
            <label id="to">To</label>
            <input type="text" name="to"
                   v-model="to"
                   class="form-control form-control-sm"
                   :class="{'is-invalid': this.errorFor('to')}"
                   placeholder="End Date"
            >
            <v-errors :errors="errorFor('to')"></v-errors>
        </div>
    </div>
    <button class="btn btn-secondary w-100 mt-3" @click="check" :disabled="loading">
      <span v-if="!loading"> Check!</span>
      <span v-if="loading"><i class="fas fa-circle-notch fa-spin"></i> Checking...</span>
    </button>
</div>
</template>

<script>
import {is422} from './../shared/utils/response';
import ValidationError from "../shared/mixins/ValidationError";

export default {
    mixins: [ValidationError],
    name: "Availability",
    props: ['bookableId'],
    data() {
        return {
            from: this.$store.state.lastSearch.from,
            to: this.$store.state.lastSearch.to,
            loading: false,
            status: null
        }
    },
    methods: {
        check() {
            this.$store.dispatch('setLastSearch', {
                from: this.from,
                to: this.to
            })
            this.loading = true;
            this.errors = null;

            axios.get(`/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`)
                .then( response => {
                    this.status = response.status;
                    this.$emit('availability', this.hasAvailability);
                })
                .catch(error => {
                    if(is422(error)) {
                        this.errors = error.response.data.errors;
                    }
                    this.status = error.response.status;
                    this.$emit('availability', this.hasAvailability);

                })
            .then(() => this.loading = false);
        }
    },
    computed: {
        hasError() {
            return this.status === 422 && this.errors != null ;
        },
        hasAvailability() {
            return this.status === 200;
        },
        noAvailability() {
            return 404 === this.status;
        }
    }

}
</script>

<style scoped>
label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: gray;
    font-weight: bolder;
}

h6 {
    font-weight: bolder;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 1s;
}

.fade-enter, .fade-leave-to {
    opacity: 0;
}


</style>
