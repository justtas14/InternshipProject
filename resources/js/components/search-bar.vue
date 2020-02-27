<template>
    <div class="searchBarContainer">
        <i class="material-icons">search</i>
        <input type="text" v-debounce:400ms="handeTitleInput" v-model="titleFilter" class="form-control searchBar" placeholder="Search product..." aria-label="Search product...">
    </div>
</template>

<script>
import Vue from 'vue'
import vueDebounce from 'vue-debounce'
 
Vue.use(vueDebounce)

export default {
    name: 'search-bar',
    components: {

    },
    data() {
        return {
            titleFilter: ''
        }
    },
    methods: {
        handeTitleInput() {
            this.$emit('filterTitle', this.titleFilter);
        },
    },
    computed: {

    },
    mounted () {
    },
    created() {

    }
};
</script>
