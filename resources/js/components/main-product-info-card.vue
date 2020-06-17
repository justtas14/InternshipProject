<template>
    <div class="container mainContainer toggleContainer">
        <vue-confirm-dialog></vue-confirm-dialog>
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
                            <div class="productButtonsContainer">
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
                                <edit-product v-if="isAdmin" v-bind:dish="dish" :allCategories="allCategories" :allVariations="allVariations" :token="token"></edit-product>
                                <div id="deleteProductContainer" v-if="isAdmin">
                                    <button :disabled="isLoadingDelete" @click="handleClick" type="button" class="btn btn-danger">Delete</button>
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
import Vue from "vue";
import axios from 'axios';
import productInfo from './productInfo.vue';
import VueConfirmDialog from 'vue-confirm-dialog'
import EditProduct from "./editProduct";

Vue.use(VueConfirmDialog);
Vue.component('vue-confirm-dialog', VueConfirmDialog.default);

export default {
    name: 'main-product-info-card',
    props: ['id', 'isAdmin', 'token'],
    components: {
        EditProduct,
        productInfo
    },
    data() {
        return {
            isLoadingDelete: false,
            isLoading: false,
            dish: null,
            selectedVariation: 'original',
            allCategories: null,
            allVariations: null,
        }
    },
    computed: {

    },
    methods: {
        handleClick(){
            this.$confirm({
                message: `Are you sure u want to delete this product?`,
                button: {
                    no: 'No',
                    yes: 'Yes'
                },
                /**
                 * Callback Function
                 * @param {Boolean} confirm
                 */
                callback: confirm => {
                    if (confirm) {
                        this.deleteProduct();
                    }
                }
            })
        },
        async deleteProduct() {
            this.isLoadingDelete = true;
            const result = await axios.post('/api/delete-product', {
                id: this.id
            }, {
                headers: { Authorization: `Bearer ${this.token}` }
            });
            this.isLoadingDelete = false;
            window.location.href="/";
        },
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
            const generalInfo = await axios.get('/api/general-info', {});
            this.allCategories = generalInfo.data.allCategories;
            this.allVariations = generalInfo.data.variations;
            this.dish = productInfo.data.dish;
            this.isLoading = false;
        } catch (error) {
            console.log(error);
        }

    }
};
</script>
