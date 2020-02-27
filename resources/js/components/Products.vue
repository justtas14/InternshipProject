<template>
    <div>
        <div v-if="isLoading" class="loadingContainer"><div class="loader">Loading...</div></div>
        <div v-else-if="dishes && dishes.length === 0" class="notFoundDishes">No products found</div>
        <div v-else class="container-fluid productsInnerContainer">
            <div  v-for="(dishInfo, index) in dishes" :key="index">
                <dish
                    v-bind:dish="dishInfo"
                ></dish>
            </div>
        </div>
    </div>
</template>

<script>
import dish from './product.vue';

export default {
    name: 'products',
    props: ['dishes', 'isLoading'],
    components: {
        dish
    },
    data() {
        return {

        }
    },
    computed: {

    },
    methods: {

    },
    mounted () {
    },
    async created() {
    }
};
</script>
