import ListenerManager from "./main/service/listenerManager";
import PixiManager from "./main/service/pixiManager";

// Global Listeners
document.addEventListener('alpine:init', () => {
    // global app Data
    Alpine.store('app', {
        pixi: null,
        listeners: null,
        currentPage: null,
        showInfo: true,
        toggleInfo(){
            this.showInfo = !this.showInfo
        },
    });
    // page data
    Alpine.store('page',{
        portfolio: {initialized: false},
        script: {},
        observer: new IntersectionObserver((items) => {
            //scrollspy
            let visible = items.filter(i => i.isIntersecting);
            if(visible.length){
                visible.sort((a, b) => Math.abs(a.boundingClientRect.top) - Math.abs(b.boundingClientRect.top));
                let sectionData = document.querySelector('footer #sectionNav nav');
                Alpine.$data(sectionData).section = visible[0].target.dataset.section;
            }     
        }, {rootMargin: '-40% 0% -60% 0%'}),
        scrollTo(section) {
            let el = document.querySelector(`section[data-section=${section}]`);
            el.scrollIntoView({scroll: 'smooth', inline: 'center', block: 'start'});
        },
        fallbackScrollSpy(sections){
            if(!('IntersectionObserver' in window)){
                const main = document.querySelector('main');
                document.addEventListener('scroll', ()=>{
                    if(document.querySelector('#innerNav')){
                    const sectionData = document.querySelector('footer #sectionNav nav');
                    sections.forEach(section => {
                        if(section.offsetTop <= main.scrollTop + main.clientHeight/2){
                             Alpine.$data(sectionData).section = section.target.dataset.section;
                        }
                        if((main.scrollTop + main.clientHeight) >= (main.scrollHeight - 1)){
                             Alpine.$data(sectionData).section = sections[sections.length - 1].target.dataset.section;
                        }
                    });
                    }
                });
            }
        },
        pageSettings: [],
        runSettings(){
            this.pageSettings.forEach(setting => setting());
        },
        clearSettings(){
            this.pageSettings = [];
        }
    });
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
        sessionStorage.setItem('active', e.detail.active);
        Alpine.store('page').pageSettings = [];
        Alpine.store('app').currentPage = e.detail.active;
    });
});

document.addEventListener('DOMContentLoaded', () => {
    Alpine.store('app').pixi = new PixiManager(document.querySelector('#canvas'));
    Alpine.store('app').listeners = new ListenerManager(document.querySelector('#canvas'));
});
