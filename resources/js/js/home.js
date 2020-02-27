export default class {
    constructor() {
        this.videoContainer = document.querySelector('.videoContainer');
    }
    goToProducts() {
        console.log('clicked');
        window.scrollTo(0, this.videoContainer.getBoundingClientRect().y + this.videoContainer.clientHeight);
    }
}
