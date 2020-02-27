<template>
    <div class="productContainer">
        <div v-if="dish.variations.length > 0" class="variationCountContainer">
            <span id="variationCount">{{ dish.variations.length }}</span>
            Variations    
        </div>
        <div @click="goToProduct()" class="dishImageContainer">
            <img :src='getDishImage()'>
        </div>
        <div @click="goToProduct()" class="dishName">
            {{ dish.name }}
        </div>
        <div class="price">
            {{ dish.price }}$
        </div>
        <div class="categoryIconsContainer">
            <div class="categoryIcon" v-for="(categoryIcon, index) in dish.categories" :key="index">
                <i class="material-icons" @mouseenter="showCategoryName(index)" @mouseleave="hideCategoryName(index)">
                    {{ categoryIcon.iconName }}
                </i>
                <div ref="categoryToolTip" class="categoryTooltip">
                    {{ categoryIcon.name }}
                </div>
            </div>
        </div>
        <div class="dishDesc">
            {{ dish.description }}
        </div>
    </div>
</template> 

<script>
export default {
    name: 'product', 
    props: ['dish'],
    components: {
    },
    data() {
        return {
        }
    },
    computed: {

    },
    methods: {
        goToProduct() {
            window.location.href = `/product-info/${this.dish.id}`;
        },
        showCategoryName(index) {
            this.$refs.categoryToolTip[index].style.display = 'block';
        },
        hideCategoryName(index) {
            this.$refs.categoryToolTip[index].style.display = 'none';
        },
        getDishImage() {
            return `/storage/images/dishes/${this.dish.profile_picture}`
        }
    },
    mounted () {
    },
    async created() {
    }
};
</script>
