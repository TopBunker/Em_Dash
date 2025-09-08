// Global Listeners
document.addEventListener('alpine:init', () => {
    // Global js Data
    Alpine.store('app', {
        currentPage: null,
        showInfo: true,
        toggleInfo(){
            this.showInfo = !this.showInfo
        },
        appSettings: [],
        runSettings(){
            this.appSettings.forEach(setting => setting());
        },
        clearSettings(){
            this.appSettings = [];
        }
    });
    Alpine.store('page',{
        observer: new IntersectionObserver((items) => {
            //scrollspy
            let visible = items.filter(i => i.isIntersecting);
            if(visible.length){
                visible.sort((a, b) => Math.abs(a.boundingClientRect.top) - Math.abs(b.boundingClientRect.top));
            }     
            if(document.querySelector('#innernav')){
                let link = document.querySelector('#innernav');
                link.__x.$data.section = visible[0].target.dataset.section;       
                visible[0].target?.scrollIntoView({behavior: 'smooth', inline: 'center', block: 'start'});
            }
            }, {rootMargin: '-20% 0% -60% 0%'}
        ),
        scrollTo(section) {
            let el = document.querySelector(`section[data-section=${section}]`);
            el.scrollIntoView({scroll: 'smooth', inline: 'center', block: 'start'});
        },
        fallbackScrollSpy(sections){
            if(!('IntersectionObserver' in window)){
                const main = document.querySelector('main');
                document.addEventListener('scroll', ()=>{
                    if(document.querySelector('#innernav')){
                    const link = document.querySelector('#innernav');
                    sections.forEach(section => {
                        if(section.offsetTop <= main.scrollTop + main.clientHeight/2){
                            link.__x.$data.section = section.target.dataset.section;
                        }
                        if((main.scrollTop + main.clientHeight) >= (main.scrollHeight - 1)){
                            link.__x.$data.section = sections[sections.length - 1].target.dataset.section;
                        }
                    });
                    }
                });
            }
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

    document.addEventListener('switchTo', (e) => {
        console.log(e);
    });
});

