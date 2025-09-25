import { Container } from "pixi.js";
import { pixifyText, block} from "../tools/build.js";
import { altGridify, altGridifyCenter, gridify, makeGrid } from "../tools/grid.js";

const txt = new Container();

const blocks = new Container();

const cover = new Container();

document.addEventListener('portfolio:ready', () => {
    const scrollable = document.querySelector('main');
    const buttons = document.querySelectorAll('#portfolio nav a');
    const parent = document.querySelector('#portfolio');
    const section = document.querySelector('#portfolio section[data-section=Writer]');
    const mainContent = document.querySelector('#portfolio section[data-section=Writer] #description');

    const app = Alpine.store('app').pixi;

    let f1 = {size: 32};
    const title = "MEET TH WRITER";
    const pTitle = pixifyText(title, 2, f1);

    let f2 = {size: 28};
    const name = "Jordane Delahaye";
    const pName = pixifyText(name, 1, f2);

    //fill grid
    let ref = window.innerWidth < window.innerHeight ? window.innerWidth : window.innerHeight;
    let sGrid = makeGrid(ref,ref, 9, 9);
    // row 1
    blocks.addChild(block(0x000000, 4, 0).fill(0x000000));
    // row 2
    blocks.addChild(altGridifyCenter(sGrid, pTitle[0], 2, 1));
    blocks.addChild(block(0x000000, 2, 1));
    blocks.addChild(altGridifyCenter(sGrid, pTitle[3], 5, 1));
    blocks.addChild(block(0x000000, 5, 1));
    // row 3
    blocks.addChild(block(0x000000, 2, 2).fill(0x000000));
    blocks.addChild(altGridifyCenter(sGrid, pTitle[1], 3, 2));
    blocks.addChild(block(0x000000, 3, 2));
    blocks.addChild(block(0x000000, 5, 2).fill(0x000000));
    blocks.addChild(altGridifyCenter(sGrid, pTitle[2], 4, 2));
    blocks.addChild(block(0x000000, 4, 2));
    blocks.addChild(block(0x000000, 6, 2).fill(0x000000));
    // row 4
    blocks.addChild(block(0x000000, 2, 3).fill(0x000000));
    blocks.addChild(block(0x000000, 3, 3).fill(0x000000));
    blocks.addChild(block(0x000000, 4, 3).fill(0x000000));
    blocks.addChild(altGridifyCenter(sGrid, pTitle[4], 5, 3));
    blocks.addChild(block(0x000000, 5, 3));
    // row 5
    blocks.addChild(block(0x000000, 3, 4).fill(0x000000));
    blocks.addChild(block(0x000000, 4, 4).fill(0x000000));
    blocks.addChild(altGridifyCenter(sGrid, pTitle[5], 5, 4));
    blocks.addChild(block(0x000000, 5, 4));
    //row 6
    blocks.addChild(altGridifyCenter(sGrid, pTitle[6], 1, 5));
    blocks.addChild(block(0x000000, 1, 5));
    blocks.addChild(altGridifyCenter(sGrid, pTitle[7], 2, 5));
    blocks.addChild(block(0x000000, 2, 5));
    blocks.addChild(altGridifyCenter(sGrid, pTitle[8], 3, 5));
    blocks.addChild(block(0x000000, 3, 5));
    blocks.addChild(altGridifyCenter(sGrid, pTitle[9], 4, 5));
    blocks.addChild(block(0x000000, 4, 5));
    blocks.addChild(altGridifyCenter(sGrid, pTitle[10], 5, 5));
    blocks.addChild(block(0x000000, 5, 5));
    blocks.addChild(altGridifyCenter(sGrid, pTitle[11], 6, 5));
    blocks.addChild(block(0x000000, 6, 5));
    // row 7
    blocks.addChild(block(0x000000, 1, 6).fill(0x000000));
    blocks.addChild(block(0x000000, 6, 6).fill(0x000000));

    // row 8
    blocks.addChild(block(0x000000, 3, 7).fill(0x000000));
    let first = altGridify(sGrid, pName[0], 4, 7);
    first.x += 5;
    first.y -= 0;
    let last = altGridify(sGrid, pName[1], 4, 7);
    last.x += 5;
    last.y += (first.height + 5);

    cover.addChild(blocks, txt, first, last);
    
    mainContent.style.marginBottom = `${cover.height + 100}px`;

    let t = 0;
    function scroller() {
        console.log('test');
        let x = scrollable.scrollTop;
        cover.y += t-x; 
        app.render();
        t = x;
    }

    function destroyer() {
        console.log('dis');
        txt.removeChildren();
        blocks.removeChildren();
        cover.removeChildren();
        app.removeChild(cover);
        Alpine.store('app').listeners.remove(scrollable, 'scroll', scroller);
        app.render();
    }

    section.addEventListener('transitionend', () => {
        if(section.style.display !== 'none'){
            cover.y = mainContent.getBoundingClientRect().bottom;
            cover.alpha = 1;
            app.addChild(cover);
            Alpine.store('app').listeners.add(scrollable, 'scroll', scroller);
            app.render();
        }else {
            cover.alpha = 0;
            Alpine.store('app').listeners.remove(scrollable, 'scroll', scroller);
            app.render();
        }
    });

    document.addEventListener('portfolio.closing', destroyer);
    document.addEventListener('portfolio:off', destroyer);

});