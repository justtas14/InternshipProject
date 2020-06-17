<template>
    <div class="addProduct">
        <i class="material-icons addIcon" @click="showModal()">add</i>
        <modal name="addProductModal">
            <div class="modalCloseButton">
                <div class="addModalTitle">Add product</div>
            </div>
            <i class="material-icons closeButton" @click="hide()">close</i>
            <form id="addProductForm">
                <div class="form-group">
                    <label for="title">Product title</label>
                    <input :disabled="isLoading" v-model="title" type="text" class="form-control" id="title" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input :disabled="isLoading" v-model="price" type="number" class="form-control" id="price" placeholder="Enter price">
                </div>
                <div class="form-group">
                    <label for="desc">Description</label>
                    <textarea :disabled="isLoading" v-model="description" class="form-control" id="desc" rows="4" placeholder="Enter description"></textarea>
                </div>
                <div class="categoriesName">Categories</div>
                <div class="form-check">
                    <div v-for="(category, index) in allCategories" :key='index' style="padding: 5px">
                        <input :disabled="isLoading" class="form-check-input" type="checkbox" :id="index" v-model="categoriesChecked[index].val">
                        <div style="display: flex; align-items: center;">
                            <i class="material-icons" >
                                {{ category.iconName }}
                            </i>
                            <label class="form-check-label categoryNameLabel" :for="index">
                                {{ category.name }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="variationsName">Variations</div>
                <div class="form-check">
                    <div v-for="(variation, index) in variations" :key='index' >
                        <input :disabled="isLoading" class="form-check-input" type="checkbox" :id="variation.name"  v-model="variationsChecked[index].val">
                        <label class="form-check-label" style="margin-left: 0.5em" :for="variation.name">
                            {{ variation.name }}
                        </label>
                    </div>
                </div>
                <div class="productProfileName">Product picture</div>
                <picture-input
                    ref="pictureInput"
                    @change="onChange"
                    width="500"
                    height="200"
                    margin="16"
                    accept="image/jpeg,image/png"
                    size="5"
                    buttonClass="btn"
                    :customStrings="{
                        upload: '<h1>Bummer!</h1>',
                        drag: 'Drag or click to add product picture'
                    }">
                </picture-input>
                <div v-if="error" class="alert alert-danger mt-4 p-3" role="alert">
                    {{ error }}
                </div>
                <div v-else-if="success" class="alert alert-success mt-4 p-3" role="alert">
                    {{ success }}
                </div>
                <div class="form-group buttonFormContainer">
                    <button :disabled="isLoading" type="button" class="btn btn-primary" @click="add()">Add product</button>
                </div>
            </form>
        </modal>
    </div>
</template>

<script>
import Vue from 'vue';
import vmodal from 'vue-js-modal';
import PictureInput from 'vue-picture-input';
import axios from "axios";
Vue.use(vmodal);

export default {
    name: 'add-product',
    components: {
        PictureInput
    },
    props: ['allCategories', 'variations', 'token'],
    data() {
        return {
            isLoading: false,
            title: null,
            price: null,
            description: null,
            categoriesChecked: [],
            variationsChecked: [],
            image: null,
            error: '',
            success: '',
        }
    },
    methods: {
        showModal() {
            this.$modal.show('addProductModal');
        },
        hide() {
            this.$modal.hide('addProductModal');
        },
        onChange (image) {
            if (image) {
                this.image = this.$refs.pictureInput.file;
            } else {
                console.log('FileReader API not supported!')
            }
        },
        async add() {
            this.error = '';
            this.success = '';
            if (!this.title  || !this.price || !this.description || !this.image) {
                this.error = "Please fill all inputs!";
            } else if (!this.checkIfExistCategory()) {
                this.error = "Please check at least one category!";
            } else {
                this.error = '';
                this.isLoading = true;
                let formData = new FormData();
                console.log(this.image);
                formData.append("image", this.image);
                formData.append("title", this.title);
                formData.append("price", this.price);
                formData.append("description", this.description);
                formData.append("categoriesChecked", JSON.stringify(this.categoriesChecked));
                formData.append("variationsChecked", JSON.stringify(this.variationsChecked));

                const result = await axios.post('api/add-product', formData, {
                    headers: { Authorization: `Bearer ${this.token}` }
                });
                this.isLoading = false;
                if (result.data.error) {
                    this.error = result.data.error;
                } else {
                    this.success = 'Product ' + this.title + ' added!';
                }
            }
        },
        checkIfExistCategory () {
            let exists = false;
            this.categoriesChecked.forEach((value, index) => {
                if (value.val) {
                    exists =  true;
                }
            });
            return exists;
        }
    },
    computed: {

    },
    watch: {
        allCategories: function (newValue, oldValue) {
            for (let i = 0; i < newValue.length; i++) {
                this.categoriesChecked.push({'val': false})
            }
        },
        variations: function (newValue, oldValue) {
            for (let i = 0; i < newValue.length; i++) {
                this.variationsChecked.push({'val': false})
            }
        }
    },
    mounted () {
    },
    created() {

    },
};
</script>

<style scoped>

</style>
