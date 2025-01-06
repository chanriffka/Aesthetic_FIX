function carousel() {
    return {
        slides: 3,
        currentIndex: 0,
        init() {
            // Auto-play functionality (optional)
            setInterval(() => {
                this.next();
            }, 5000);
        },
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.slides;
        },
        prev() {
            this.currentIndex = (this.currentIndex - 1 + this.slides) % this.slides;
        },
        goToSlide(index) {
            this.currentIndex = index;
        }
    };
}