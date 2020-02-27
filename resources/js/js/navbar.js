export default class {
    constructor() {
        this.navBarExpand = true;
        this.loginCard = document.getElementById('loginCard');
        this.backgroundOverlay = document.getElementsByClassName('background__overlay')[0];
        this.toggleButtonContainer = document.querySelector('.toggleButtonContainer');
        this.toggleButton = document.getElementById('toggleButton');
        this.navItems = document.getElementsByClassName('navItem');
        this.navContainer = document.getElementsByClassName('navContainer');
        this.mainContainers = document.getElementsByClassName('mainContainer');
    }
    expandNavBar() {
        this.navBarExpand = true;
        this.toggleButtonContainer.classList.add("fullWidth");
        if (this.mainContainers.length > 0) {
            this.mainContainers[0].classList.add('toggleContainer');
        }
        for (let i = 0; i < this.navItems.length; i++) {
            setTimeout(() => {
                this.navItems[i].classList.remove('hideNavItem');
                this.navItems[i].classList.add('showNavItem');
            }, (i+25) * ((i+1)*(i+1)));
        }
        this.navContainer[0].classList.add('navContainerExpand');
        this.toggleButton.classList.add('is-active');
        if (this.checkIfMobile()) {
            this.toggleButton.classList.add('mobileBtn');
            this.toggleButtonContainer.classList.add('mobileContainer');
        }
    }
    narrowNavBar() {
        this.navBarExpand = false;
        if (this.mainContainers.length > 0) {
            this.mainContainers[0].classList.remove('toggleContainer');
        }
        this.backgroundOverlay.classList.remove('background__overlay__show');
        this.loginCard.style.display = "none";
        this.toggleButtonContainer.classList.remove("fullWidth");
        for (let i = 0; i < this.navItems.length; i++) {
            setTimeout(() => {
                this.navItems[i].classList.add('hideNavItem');
                this.navItems[i].classList.remove('showNavItem');
            }, (i + 25) * (i + 1))
        }
        this.navContainer[0].classList.remove('navContainerExpand');
        this.toggleButton.classList.remove('is-active');
        if (this.checkIfMobile()) {
            this.toggleButton.classList.remove('mobileBtn');
            this.toggleButtonContainer.classList.remove('mobileContainer');
        }
    }
    checkIfMobile() {
        let windowWitdh = window.innerWidth;
        let isMobile = false;
        if (windowWitdh <= 550) {
            isMobile = true;
        }
        return isMobile;
    }
    addMobileClasses() {
        let windowWitdh = window.innerWidth;
        if (windowWitdh > 550) {
            this.toggleButtonContainer.classList.remove('mobileContainer');
            this.toggleButton.classList.remove('mobileBtn');
        } else {
            if (this.toggleButtonContainer.classList.contains('fullWidth')) {
                this.toggleButtonContainer.classList.add('mobileContainer');
                this.toggleButton.classList.add('mobileBtn');
            }
        }
    }
    navbarToggleAnimation() {
        this.addMobileClasses();
        window.addEventListener('resize', () => {
            this.addMobileClasses();
        });

        let canToggle = true;
        this.toggleButton.addEventListener('click', () => {
            if (this.navBarExpand === false) {
                this.expandNavBar();
            } else {
                if (canToggle) {
                    this.narrowNavBar();
                }
            }
            canToggle = false;
            setTimeout(() => {
                canToggle = true;
            }, 1000)
        });
    }
    toggleLogin(afterError = null) {
        if (this.loginCard.style.display === "none" || afterError) {
            this.backgroundOverlay.classList.add('background__overlay__show');
            this.loginCard.style.display = "block";
            this.loginCard.classList.remove('walkOut');
            this.loginCard.classList.add('walkIn');
        } else {
            this.backgroundOverlay.classList.remove('background__overlay__show');
            this.loginCard.classList.remove('walkIn');
            this.loginCard.classList.add('walkOut');
            setTimeout(() => {
                this.loginCard.style.display = 'none';
            }, 450);
        }
    }
    toggleDetailsBox() {
        const toggleDetailsBox = document.getElementById('userDetailBox');
        const arrowIcon = document.querySelector('.navName i');
        if (toggleDetailsBox.classList.contains('rotateInDetailsBox')) {
            arrowIcon.classList.remove('arrowIconExpand');
            toggleDetailsBox.classList.remove('rotateInDetailsBox');
        } else {
            arrowIcon.classList.add('arrowIconExpand');
            toggleDetailsBox.classList.add('rotateInDetailsBox');
        }
    }

    scrollVertically() {
        const video = document.querySelector('video');
        const navContainer = this.toggleButtonContainer;
        if (video) {
            window.addEventListener('scroll', () => {
                if ((Math.abs(video.getBoundingClientRect().y) + navContainer.clientHeight) > video.clientHeight - 20) {
                    if (!navContainer.classList.contains('visibleBackground')) {
                        navContainer.classList.add('visibleBackground');
                    }
                } else {
                    navContainer.classList.remove('visibleBackground');
                }
            })
        } else {
            navContainer.classList.add('visibleBackground');
        }

    }
}

