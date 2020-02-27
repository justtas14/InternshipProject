<template>
    <div class="container-fluid productsContainer">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card customCard homeCard">
                    <div class="card-body productsBody">
                        <toolbar 
                            v-bind:isLoading="isLoading"
                            v-bind:allCategories="allCategories"
                            v-bind:dishesCount="dishesCount"
                            @filterTitle="filterTitle"
                            @filterCategories="filterCategories"
                        ></toolbar>
                        <products
                            v-bind:isLoading="isLoading"
                            v-bind:dishes="dishes"
                        >
                        </products>
                        <pagination 
                            v-bind:isLoadingPages="isLoadingPages"
                            v-bind:currentPage="currentPage"
                            v-bind:numberOfPages="pagesCount"
                            @previousPage="previousPage()"
                            @nextPage="nextPage()"
                            @specificPage="page"
                        ></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import toolbar from './toolbar.vue';
import products from './products.vue';
import pagination from './pagination.vue';
import axios from 'axios';

export default {
    name: 'main-products-card', 
    components: {
        toolbar,
        products,
        pagination
    },
    data() {
        return {
            isLoading: false,
            isLoadingPages: false,
            categoriesFilter: '',
            searchTitleFilter: '',
            dishes: null,
            allCategories: null,
            dishesCount: 0,
            pagesCount: 1,
            currentPage: 1
        }
    },
    computed: {

    },
    methods: {
        previousPage() {
            this.currentPage--;
            this.getGeneralProductsInfo(this.currentPage);
        },
        nextPage() {
            this.currentPage++;
            this.getGeneralProductsInfo(this.currentPage);
        },
        page(n) {
            this.currentPage = n;
            this.getGeneralProductsInfo(n);
        },
        async getGeneralProductsInfo(page) {
            this.isLoading = true; 
            const productsInfo = await axios.get(`/api/products-filter/${page}`, {
                params: {
                    categoriesFilter: this.categoriesFilter,
                    searchTitleFilter: this.searchTitleFilter
                }
            });
            this.dishes = productsInfo.data.dishes;
            this.dishesCount = productsInfo.data.dishesCount;
            this.pagesCount = productsInfo.data.pagesCount;
            this.isLoading = false;
        },
        filterCategories(e) {
            this.categoriesFilter = e;
            this.filter();  
        },
        filterTitle(e) {
            this.searchTitleFilter = e;
            this.filter();
        },
        async filter() {
            this.currentPage = 1;
            this.isLoadingPages = true;
            await this.getGeneralProductsInfo(this.currentPage);
            this.isLoadingPages = false;
        }

    },
    mounted () {

    },
    async created() {
        try {
            this.getGeneralProductsInfo(this.currentPage);
            this.isLoading = true; 
            const generalInfo = await axios.get('api/general-info', {});
            this.allCategories = generalInfo.data.allCategories;
            this.isLoading = false; 
        } catch (error) {
            console.log(error);
        }
        
    }
};
</script>
