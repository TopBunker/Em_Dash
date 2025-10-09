import ListenerManager from "./main/service/listenerManager";
import PixiManager from "./main/service/pixiManager";

// Alpine initialized via Livewire
document.addEventListener('alpine:init', () => {    
    // APP STORE
    Alpine.store('app', {
        pixi: null,
        listeners: new ListenerManager(),
        currentPage: null,
        showInfo: true,
        headHeight: window.innerHeight / 4.05,
        toggleInfo(){
            this.showInfo = !this.showInfo
        },
    });

    // PAGE STORE
    Alpine.store('page', {
        portfolio: {initialized: false},
        script: {},
        scrollTo(el) {
            el.scrollIntoView({behavior: 'smooth', block: 'start'});
        },
        cycleIndex(current, direction, length) {
            return (current + direction + length) % length;
        },
        pageSettings: [],
        runSettings(){
            this.pageSettings.forEach(setting => setting());
        },
        clearSettings(){
            this.pageSettings = [];
        }
    });

    // COMPONENT SERVICES
    /** 
     * ScrollSpy
     * context: string - the name of the page or context for the scroll spy
     * scroller: Element - the scrollable element (default is main)
     * observe: array|NodeList|Element - the elements to be observed for intersection or scroll position (converted to array)
     * initalState: string - the initial value of the variable tracking current observed intersection
     * intersection: object - IntersectionObserver options (default is {rootMargin: '-40% 0% -60% 0%'} )
     */
    Alpine.data('scrollSpy', (observe = [], page = Alpine.store('app').currentPage, current = null, scroller = document.querySelector('main'), intersectWith = {rootMargin: '-40% 0% -60% 0%'}) => ({
        observees: Array.isArray(observe) 
            ? observe
            : (observe instanceof NodeList
                ? Array.from(observe)
                : (observe instanceof Element ? [observe] : [])),
        root: intersectWith,
        page,
        current,
        scroller,
        IO: null,
        handler: null,
        observer() {
            this.IO = new IntersectionObserver((items) => {
                let visible = items.filter(i => i.isIntersecting);
                if(visible.length){
                    visible.sort((a, b) => Math.abs(a.boundingClientRect.top) - Math.abs(b.boundingClientRect.top));
                    this.current = visible[0].target.dataset.section;
                }     
            }, this.root)
        },
        fallbackScrollSpy: {
            fn() {
                // Bind the handler to this instance
                this.handler = () => {
                    this.observees.forEach(section => {
                        if (section && section.offsetTop !== undefined && section.dataset && section.dataset.section !== undefined) {
                            if (section.offsetTop <= this.scrollable.scrollTop + this.scrollable.clientHeight / 2) {
                                this.current = section.dataset.section;
                            }
                        }
                    });
                    if ((this.scrollable.scrollTop + this.scrollable.clientHeight) >= (this.scrollable.scrollHeight - 1)) {
                        const lastSection = this.observees[this.observees.length - 1];
                        if (lastSection && lastSection.dataset && lastSection.dataset.section !== undefined) {
                            this.current = lastSection.dataset.section;
                        }
                    }
                };
                Alpine.store('app').listeners.add(this.scrollable, 'scroll', this.handler, { passive: true });
            },
            destroy() {
                if (this.handler) {
                    Alpine.store('app').listeners.remove(this.scrollable, 'scroll', this.handler, { passive: true });
                    this.handler = null;
                }
            },
        },
        init() {
            // Validate observees is not empty
            if (this.observees.length === 0) {
                throw new Error('observe array is empty. Please provide at least one element to observe.');
            }
            // Check for IntersectionObserver support
            if(!('IntersectionObserver' in window)){
                this.fallbackScrollSpy.fn.call(this);
            } else {
                this.observer();
                this.observees.forEach(section => this.IO.observe(section));
            }
        },
        destroy() {
            if(this.IO){
                this.IO.disconnect();
            }
            this.fallbackScrollSpy.destroy.call(this);
        }
    }));

    /**
     * Gallery Manager
     * media: object storing iterable list of gallery items
     */
    Alpine.data('gallery', ({media = []} = {}) => ({
        media,
        activeIndex: null,
        startX: 0,
        endX: 0,
        open(i) {
            this.activeIndex = i;
            document.body.style.overflow = 'hidden';
            this.preloadNeighborImages();
        },
        close() {
            this.activeIndex = null;
            document.body.style.overflow = '';
        },
        next() {
            if (!this.media.length) return;
            this.activeIndex = Alpine.store('page').cycleIndex(this.activeIndex, +1, this.media.length);
            this.preloadNeighborImages();
        },
        prev() {
            if (!this.media.length) return;
            this.activeIndex = Alpine.store('page').cycleIndex(this.activeIndex, -1, this.media.length);
            this.preloadNeighborImages();
        },
        preloadNeighborImages() {
            if (!this.media.length) return;
            const next = this.media[Alpine.store('page').cycleIndex(this.activeIndex, +1, this.media.length)];
            const prev = this.media[Alpine.store('page').cycleIndex(this.activeIndex, -1, this.media.length)];
            [next, prev].forEach(item => {
                if (item['type'] === 'image') {
                    const i = new Image();
                    i.src = item.location;
                }
            });
        },
        handleSwipe() {
            if (this.startX - this.endX > 50) { this.next(); }
            if (this.endX - this.startX > 50) { this.prev(); }
        }
    }));
});

document.addEventListener('livewire:initialized', () => {
    // Scroll functions
    // close header 
    const main = document.querySelector('main');
    const app = document.querySelector('#app');
    let dragging = false;
    let startY = 0;
    let prev = 0;
    document.addEventListener('pointerdown', (event) => {
        if((main.scrollHeight <= window.innerHeight) || ((main.scrollHeight > window.innerHeight) && main.scrollTop === 0)){
            dragging=true;
            startY=event.clientY;
        }
    });
    document.addEventListener('pointermove', (event) => {
        if(!dragging){return}
        let dy = event.clientY - startY;
        if(dy < 0){Alpine.store('app').showInfo = false}
        if(dy > 10){Alpine.store('app').showInfo = true}
    },{passive: true});
    window.addEventListener('pointerup', () => {dragging=false});

    // update local storage and clear settings on page navigation
    document.addEventListener('switchTo', (e) => {
        let to = e.detail.active;
        sessionStorage.setItem('active', to);
        Alpine.store('page').pageSettings = [];
    });
});

document.addEventListener('DOMContentLoaded', async () => {
    const canvasEl = document.querySelector('#canvas');
    if (canvasEl) {
        Alpine.store('app').pixi = new PixiManager(canvasEl);
    } else {
        console.warn('Canvas element with id "#canvas" not found. PixiManager not initialized.');
    }
});
