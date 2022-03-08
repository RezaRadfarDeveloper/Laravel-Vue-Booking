<template>
    <div>

        <div v-if="loading">
            Data is loading ...
        </div>
        <div v-else>
            <div class="row mb-3" v-for="row in rows" :key="'row' + row">
                <div class="col d-flex align-items-stretch" v-for="(bookable,column) in itemsInRow(row)">
                    <bookable-list-item
                        :title="bookable.title"
                        :description="bookable.description"
                        :id="bookable.id"
                    >
                    </bookable-list-item>
                </div>
                <div class="col" v-for="p in placeholderInRow(row)">
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import BookableListItem from "./BookableListItem";
export default {
    name: "Bookables",
    components: {
        BookableListItem
    },
    data() {
        return {
                bookables:null,
                loading: false,
                columns: 3
               }
            },
    computed: {
        rows() {
          return  this.bookables!= null
              ? Math.ceil(this.bookables.length/ this.columns)
              : 0 ;
        }
    },
    methods:{
        itemsInRow(row) {
           return  this.bookables.slice((row - 1) * this.columns, row * this.columns)
        },
        placeholderInRow(row) {
           return  this.columns -  this.itemsInRow(row).length ;
        }
    },
    created() {
        this.loading = true;

        // const p = new Promise((resolve,reject)=> {
        //     console.log(resolve);
        //     console.log(reject);
        //     setTimeout(()=> resolve('hello'),3000);
        // }).then((result) => console.log(`successfull {$result}` ))
        //   .catch(result => console.log(`Error {$result}`));
        // console.log(p);
            axios.get('api/bookables').then(response => {
                this.bookables= response.data.data;
                this.bookables.push({'title': 'x', 'description': 'oo'});
                this.loading = false;
            })
        // setTimeout(()=> {
        //         this.bookables=[
        //             {
        //             title:'villa 1',
        //             content: 'content villa 1'
        //     },
        //         {
        //             title: 'villa 2',
        //             content: 'content villa 2'
        //     },
        //     {
        //         title:'villa 1',
        //         content: 'content villa 1'
        //     },
        //     {
        //         title:'villa 1',
        //         content: 'content villa 1'
        //     },
        //     {
        //         title:'villa 1',
        //         content: 'content villa 1'
        //     },
        //     {
        //         title:'villa 1',
        //         content: 'content villa 1'
        //     },
        //     {
        //         title:'villa 1',
        //         content: 'content villa 1'
        //     }];
        //         this.loading = false;
        //     },
        // 2000)

    }
}

</script>

<style scoped>

</style>
