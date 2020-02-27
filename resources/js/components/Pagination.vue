<template>
    <div>
        <content-loader
            v-if="isLoadingPages"
            :height="80"
            :width="400"
            :speed="2"
            primaryColor="#f3f3f3"
            secondaryColor="#ecebeb"
        >
        <rect x="64.4" y="20" rx="0" ry="0" width="250" height="43" />
    </content-loader>
        <ul v-else class="pagination">
            <li v-if="currentPage == 1" class="disabled leftPage">
                <a href="#!"><i class="material-icons">chevron_left</i></a>
            </li>
            <li v-else><a @click="previousPage" class="leftPage">
                <i class="material-icons">chevron_left</i></a>
            </li>
            <li v-if="currentPage - 1 > numberOfPagesToShow" class="firstPage" @click="page(1)">
                <a href="#" class="hrefPages">{{ 1 }}</a>
            </li>
            <li v-if="currentPage - 1 > numberOfPagesToShow+1"
                class="paginationDots">...</li>
            <span id="pages">
                <li v-for="n in numberOfPages" :key="n" v-show="(Math.abs(currentPage-n) < numberOfPagesToShow+1)"
                v-bind:class="[n == currentPage ? 'activePage': 'notActivePage']" @click="page(n)">
                    <a class="hrefPages" :class="{'currentPage': (n == currentPage)}">{{ n }}
                    </a>
                </li>
            </span>
            <li
            v-if="(numberOfPages - currentPage > numberOfPagesToShow+1)"
            class="paginationDots">...</li>
            <li v-if="numberOfPages - currentPage > numberOfPagesToShow" class="lastPage" @click="page(numberOfPages)">
                <a
                    class="hrefPages">{{ numberOfPages }}
                </a>
            </li>
            <li v-if="currentPage == numberOfPages"
            id="disabled_right" class="disabled rightPage">
                <a href="#!"><i class="material-icons">chevron_right</i></a>
            </li>
            <li v-else id="enabled_right" class="rightPage">
                <a @click="nextPage"><i class="material-icons">chevron_right</i></a>
            </li>
        </ul>
    </div>
</template>

<script>
import { ContentLoader } from 'vue-content-loader'

export default {
    name: 'Pagination',
    props: ['currentPage', 'numberOfPages', 'isLoadingPages'],
    components: {
        ContentLoader,
    },
    data() {
        return {
            numberOfPagesToShow: 3,
        };
    },
    methods: {
        previousPage() {
            this.$emit('previousPage');
        },
        nextPage() {
            this.$emit('nextPage');
        },
        page(n) {
            this.$emit('specificPage', n);
        },
    },
};
</script>