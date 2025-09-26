import { Container } from "pixi.js";
import { pixifyText, block} from "../tools/build.js";
import { altGridify, altGridifyCenter, gridify, makeGrid } from "../tools/grid.js";

let txt = new Container();
let blocks = new Container();
let cover = new Container();

let f1 = {size: 32};
const title = "MEET TH WRITER";
const pTitle = pixifyText(title, 2, f1);

let f2 = {size: 28};
const name = "Jordane Delahaye";
const pName = pixifyText(name, 1, f2);


function build(gridReference) {
    // row 1
    blocks.addChild(block(gridReference, 0x000000, 4, 0).fill(0x000000));
    // row 2
    blocks.addChild(altGridifyCenter(gridReference, pTitle[0], 2, 1));
    blocks.addChild(block(gridReference, 0x000000, 2, 1));
    blocks.addChild(altGridifyCenter(gridReference, pTitle[3], 5, 1));
    blocks.addChild(block(gridReference, 0x000000, 5, 1));
    // row 3
    blocks.addChild(block(gridReference, 0x000000, 2, 2).fill(0x000000));
    blocks.addChild(altGridifyCenter(gridReference, pTitle[1], 3, 2));
    blocks.addChild(block(gridReference, 0x000000, 3, 2));
    blocks.addChild(block(gridReference, 0x000000, 5, 2).fill(0x000000));
    blocks.addChild(altGridifyCenter(gridReference, pTitle[2], 4, 2));
    blocks.addChild(block(gridReference, 0x000000, 4, 2));
    blocks.addChild(block(gridReference, 0x000000, 6, 2).fill(0x000000));
    // row 4
    blocks.addChild(block(gridReference, 0x000000, 2, 3).fill(0x000000));
    blocks.addChild(block(gridReference, 0x000000, 3, 3).fill(0x000000));
    blocks.addChild(block(gridReference, 0x000000, 4, 3).fill(0x000000));
    blocks.addChild(altGridifyCenter(gridReference, pTitle[4], 5, 3));
    blocks.addChild(block(gridReference, 0x000000, 5, 3));
    // row 5
    blocks.addChild(block(gridReference, 0x000000, 3, 4).fill(0x000000));
    blocks.addChild(block(gridReference, 0x000000, 4, 4).fill(0x000000));
    blocks.addChild(altGridifyCenter(gridReference, pTitle[5], 5, 4));
    blocks.addChild(block(gridReference, 0x000000, 5, 4));
    //row 6
    blocks.addChild(altGridifyCenter(gridReference, pTitle[6], 1, 5));
    blocks.addChild(block(gridReference, 0x000000, 1, 5));
    blocks.addChild(altGridifyCenter(gridReference, pTitle[7], 2, 5));
    blocks.addChild(block(gridReference, 0x000000, 2, 5));
    blocks.addChild(altGridifyCenter(gridReference, pTitle[8], 3, 5));
    blocks.addChild(block(gridReference, 0x000000, 3, 5));
    blocks.addChild(altGridifyCenter(gridReference, pTitle[9], 4, 5));
    blocks.addChild(block(gridReference, 0x000000, 4, 5));
    blocks.addChild(altGridifyCenter(gridReference, pTitle[10], 5, 5));
    blocks.addChild(block(gridReference, 0x000000, 5, 5));
    blocks.addChild(altGridifyCenter(gridReference, pTitle[11], 6, 5));
    blocks.addChild(block(gridReference, 0x000000, 6, 5));
    // row 7
    blocks.addChild(block(gridReference, 0x000000, 1, 6).fill(0x000000));
    blocks.addChild(block(gridReference, 0x000000, 6, 6).fill(0x000000));

    // row 8
    blocks.addChild(block(gridReference, 0x000000, 3, 7).fill(0x000000));

    let first = altGridify(gridReference, pName[0], 4, 7);
    first.x += 5;
    first.y -= 0;
    let last = altGridify(gridReference, pName[1], 4, 7);
    last.x += 5;
    last.y += (first.height + 5);

    txt.addChild(first, last);

    cover.addChild(blocks, txt);
    cover.y = window.innerHeight;
}

function reset() {
    txt = new Container();
    blocks = new Container();
    cover = new Container();
}

document.addEventListener('portfolio:ready', () => {
    const scrollable = document.querySelector('main');
    const section = document.querySelector('#portfolio section[data-section=Writer]');
    const mainContent = document.querySelector('#portfolio section[data-section=Writer] #description');

    const app = Alpine.store('app').pixi;

    // fill grid
    let ref = window.innerWidth < window.innerHeight ? window.innerWidth : window.innerHeight;
    let gridReference = makeGrid(ref,ref, 9, 9);

    build(gridReference);

    const viewPane = document.createElement('span');
    viewPane.style.width = '100%';
    viewPane.style.height = `${cover.height + 100}px`;
    mainContent.after(viewPane);

    let set = false;
    function setUp() {
        if (!set) {
            if(section.getBoundingClientRect().height > 0){
                if(scrollable.scrollTop === 0) {
                    t = 0;
                    cover.y = mainContent.getBoundingClientRect().bottom + 50;
                    app.addChild(cover);
                    app.render();
                    Alpine.store('app').listeners.add(scrollable, 'scroll', scroller);
                    set = true;
                    console.log('set');
                } else {
                    setTimeout(setUp, 500);
                }
            }
        }
    }

    function remove() {
        Alpine.store('app').listeners.remove(scrollable, 'scroll', scroller);
        app.removeChild(cover);
        app.render();
        set = false;
    }

    function removeReset() {
        remove();
        reset();
    }

    let t = 0;
    function scroller() {
        const x = scrollable.scrollTop;
        cover.y += t-x; 
        app.render();
        t = x;
    }
    
    
    section.addEventListener('transitionend', setUp);
    
    document.addEventListener('portfolio.opening', (e) => {
        if (e.detail.name !== 'Writer') {
            remove();
        }
    });

    document.addEventListener('portfolio.closing', remove);
    document.addEventListener('portfolio:off', removeReset, {once: true});
});