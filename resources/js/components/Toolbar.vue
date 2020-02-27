<template>
    <div class="toolbarContainer">
        <div class="searchContainer">
            <search-bar
                @filterTitle="e => $emit('filterTitle', e)" 
            ></search-bar>
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

export default {
    name: 'toolbar',
    components: {
        'search-bar': SearchBar,
        'categories-filter': filter
    },
    props: ['allCategories', 'dishesCount', 'isLoading'],
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
