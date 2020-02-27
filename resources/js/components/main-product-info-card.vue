<template>
    <div class="container mainContainer toggleContainer">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card customCard homeCard productInfoCard">
                    <div v-if="isLoading" class="loadingContainer"><div class="loader">Loading...</div></div>
                    <div v-else class="card-body productsBody productInfoBody">
                        <div class="productInfoToolbar">
                            <div class="categoryIconsContainer infoCategories">
                                <div class="categoryIcon" v-for="(categoryIcon, index) in dish.categories" :key="index"
                                @mouseenter="showCategoryName(index)" @mouseleave="hideCategoryName(index)" 
                                :class="{'allignIconStart' : index % 2 === 1}">
                                    <i class="material-icons"  >
                                        {{ categoryIcon.iconName }}
                                    </i>
                                    <div ref="categoryToolTip" class="categoryTooltip">
                                        {{ categoryIcon.name }}
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown show" v-if="dish.variations.length > 0">
                                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ selectedVariation === 'original' ? 'Original' : selectedVariation.name}}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a @click="chooseVariation('original')"
                                    class="dropdown-item" :class="{'selected': selectedVariation==='original'}"
                                    >
                                        Original
                                    </a>
                                    <a @click="chooseVariation(variation)" 
                                        v-for="(variation, index) in dish.variations" :key="index"
                                        class="dropdown-item" :class="{'selected': selectedVariation.name===variation.name}">
                                        {{ variation.name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <productInfo
                            v-bind:dish="dish"
                            v-bind:selectedVariation="selectedVariation"
                        ></productInfo>
                    </div>
                </div>
            </div>
        </div>
</div>
</template>

<script>
import axios from 'axios';
import productInfo from './productInfo.vue';

export default {
    name: 'main-product-info-card', 
    props: ['id'],
    components: {
        productInfo
    },
    data() {
        return {
            isLoading: false,
            dish: null,
            selectedVariation: 'original',
        }
    },
    computed: {

    },
    methods: {
        chooseVariation(variation) {
            this.selectedVariation = variation;
        },
        showCategoryName(index) {
            this.$refs.categoryToolTip[index].style.display = 'block';
        },
        hideCategoryName(index) {
            this.$refs.categoryToolTip[index].style.display = 'none';
        },
    },
    mounted () {

    },
    async created() {
        try {
            this.isLoading = true; 
            const productInfo = await axios.get(`/api/product-info/${this.id}`, {});     
            this.dish = productInfo.data.dish;       
            this.isLoading = false; 
        } catch (error) {
            console.log(error);
        }
        
    }
};
</script>
