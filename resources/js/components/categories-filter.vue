<template>
    <div class="filter">
        <i class="material-icons filterIcon" @click="filterShow = !filterShow">filter_list</i>
        <transition name="fade">
            <categoriesBox 
                v-bind:allCategories="allCategories" 
                v-show="filterShow" 
                v-if="allCategories"
                @closeCategoriesBox="filterShow=false"
                @filterCategories="e => $emit('filterCategories', e)"
                >
            </categoriesBox>
        </transition>
    </div>
</template>

<script>
import categoriesBox from './categories-box.vue';

export default {
    name: 'categories-filter',
    components: {
        categoriesBox
    },
    props: ['allCategories', 'isLoading'],
    data() {
        return {
            filterShow: false,
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
