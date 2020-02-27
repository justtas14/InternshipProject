<template>
    <div class="productInfoContainer">
        <div class="dishImageContainer">
            <zoom-on-hover :img-normal='getDishImage()' :scale="2" :disabled="false"></zoom-on-hover>
        </div>
        <div class="dishName">
            {{ name}}
        </div>
        <div class="price">
            {{ price}}$
        </div>
        <div class="dishDesc">
            {{ dish.description }}
        </div>
    </div>
</template> 

<script>
import Vue from 'vue';
import ZoomOnHover from "vue-zoom-on-hover";

Vue.use(ZoomOnHover);

export default {    
    name: 'product', 
    props: ['dish', 'selectedVariation'],
    components: {
    },
    data() {
        return {
        }
    },
    computed: {
        name() {
            let name = this.dish.name;
            if (this.selectedVariation.name) {
                name += ' - ' + this.selectedVariation.name;
            }
            return name;
        },
        price() {
            let price = parseFloat(this.dish.price);
            if (this.selectedVariation.increased_amount) {
                price += parseFloat(this.selectedVariation.increased_amount);
            }
            return price;
        }

    },
    methods: {
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
