<template>
    <div class="categoriesBox">
        <div class="triangle-with-shadow"></div>
        <div class="categoriesBoxItem" @click="$emit('closeCategoriesBox')">
            <i class="material-icons">close</i>  
        </div>
        <div class="categoriesBoxItem" v-for="(category, index) in allCategories" :key='index' @click="toggleCategory(index)">
            <div class="checkboxContainer">
                 <div class="pretty p-switch p-fill">
                    <input type="checkbox" name="switch1" v-model="categoriesChecked[index].val"/>
                    <div class="state p-info">
                        <label></label>
                    </div>
                </div>
            </div>
            <div class="categoryIconContainer">
                <i class="material-icons" :class="{'hoveredIcon': categoriesChecked[index].val}">
                    {{ category.iconName }}
                </i>
            </div>
            <div class="categoryName" :class="{'hoveredCategory': categoriesChecked[index].val}">
                {{ category.name }}
            </div>
        </div>  
        <div class="categoriesBoxItem filterContainer" @click="filter">
            <button class="btn btn-primary">Filter</button>
        </div>
    </div>
</template>

<script>
import Vue from 'vue';
import PrettyCheckbox from 'pretty-checkbox-vue';

Vue.use(PrettyCheckbox);

export default {
    name: 'categories-box',
    components: {
    },
    props: ['allCategories'],
    data() {
        return {
            categoriesChecked: [
                {
                    'val': false,
                }, 
                {
                    'val': false,
                },
                {
                    'val': false,
                },
                {
                    'val': false,
                },
                {
                    'val': false,
                }
            ],
            oldCategoriesChecked: [],
        }
    },
    methods: {
        toggleCategory(index) {
            this.categoriesChecked[index].val = !this.categoriesChecked[index].val;
        },
        arraysEqual(arr1, arr2) {
            if(arr1.length !== arr2.length) {
                return false;
            }
            for(var i = arr1.length; i--;) {
                if(arr1[i].val !== arr2[i].val) {
                    return false;
                }
            }
            return true;
        },
        filter() {
            if (!this.arraysEqual(this.categoriesChecked, this.oldCategoriesChecked)) {
                const selectedCategories = this.categoriesChecked.filter((item) => item.val === true); 
                this.$emit('filterCategories', selectedCategories);
                this.oldCategoriesChecked = JSON.parse(JSON.stringify(this.categoriesChecked));
            }
        }
    },
    computed: {

    },  
    mounted () {
        for (let i = 0; i < this.allCategories.length; i++) {
            this.categoriesChecked[i].name = this.allCategories[i].name;
        }
    },
    created() {
        this.oldCategoriesChecked = JSON.parse(JSON.stringify(this.categoriesChecked));
    }
};
</script>
