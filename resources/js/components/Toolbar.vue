<template>
    <div class="toolbarContainer">
        <div class="searchContainer">
            <search-bar
                @filterTitle="e => $emit('filterTitle', e)"
            ></search-bar>
            <div v-if="isAdmin" class="addProductContainer">
                <add-product v-bind:token="token" v-bind:allCategories="allCategories" v-bind:variations="variations"></add-product>
            </div>
        </div>
        <div class="itemsCountContainer">
            <div class="itemsCount">
                {{ dishesCount }}
            </div>
            <div class="itemsCountDesc">
                items
            </div>
        </div>
        <div class="filterContainer">
            <categories-filter
                v-bind:allCategories="allCategories"
                v-bind:isLoading="isLoading"
                @filterCategories="e => $emit('filterCategories', e)"
            ></categories-filter>
        </div>
    </div>
</template>

<script>
import SearchBar from './search-bar.vue';
import filter from './categories-filter.vue';
import addProduct from "./addProduct";

export default {
    name: 'toolbar',
    components: {
        'search-bar': SearchBar,
        'categories-filter': filter,
        'add-product': addProduct
    },
    props: ['allCategories', 'dishesCount', 'isLoading', 'isAdmin', 'variations', 'token'],
    data() {
        return {
        }
    },
    methods: {

    },
    computed: {

    },
    mounted () {

    },
    created() {
    }
};
</script>
