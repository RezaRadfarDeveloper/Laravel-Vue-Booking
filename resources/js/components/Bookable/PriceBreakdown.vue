<template>
    <div>
        <h6 class="text-uppercase text-secondary bolder">price breakdown</h6>
        <div v-for="(days,price) in price.breakdown" :key="price" class="pt-2 pb-2 border-bottom border-top d-flex justify-content-between">
              <span>{{days}} x ${{price}}</span>
              <span>{{days * price}}</span>
        </div>
        <div class="bolder pt-2 d-flex justify-content-between">
             <span>Total:</span>
             <span>${{price.total}}</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['price'],
    name: "PriceBreakdown"
}
</script>

<style scoped>
.bolder {
    font-weight: bolder;
}
</style>
