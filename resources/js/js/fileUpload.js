export default class {
    constructor() {
        this.fileUploadInputs = document.querySelectorAll('.file-upload');
    }
    selectFile() {
        this.fileUploadInputs[0].click();
    }
    readUrl(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                document.getElementsByClassName('profile-pic')[0].src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }



}
