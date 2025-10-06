import { Container } from "pixi.js";
import { pixifyText, block} from "../tools/build.js";
import { altGridify, altGridifyCenter, gridify, makeGrid } from "../tools/grid.js";

let txt = new Container();
let blocks = new Container();
let cover = new Container();
let container = new Container();

let scrollState, animationState, transitionState;

$(async () => {
    const pixi = Alpine.store('app').pixi;
    await pixi.ready;

    await pixi.addChild(container);

    const listener = Alpine.store('app').listeners;

    // set up animation elements
    let f1 = {size: 32};
    const title = "MEETTHWRITER".split('');
    const placeholder = "XXXXXXXXXXXX";
    const pTitle = pixifyText(placeholder, 2, f1);

    let f2 = {size: 28};
    const name = "Jordane Delahaye";
    const pName = pixifyText(name, 1, f2);


    let ref = window.innerWidth < window.innerHeight ? window.innerWidth : window.innerHeight;
    let gridReference = makeGrid(ref,ref, 9, 9);

    function build() {
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

        blocks.addChild(txt);
        blocks.y = window.innerHeight;

        container.addChild(blocks);
    }

    function buildCover() {
        cover = new Container();
        for (let r = 0; r < 9; r++) {
            for (let c = 0; c < 9; c++) {
                cover.addChild(block(gridReference, 0x000000, c, r).fill(0x000000));
            }
        }
        cover.y = window.innerHeight;
    }

    function reset() {
        txt.removeChildren();
        blocks.removeChildren();
        cover.removeChildren();
    }

    await pixi.addTicker((delta) => {
        scrollState?.(delta);
        animationState?.(delta);
        transitionState?.(delta);
    });

    const nullState = (delta) => {};

    scrollState = nullState;
    animationState = nullState;
    transitionState = nullState;

    document.addEventListener('portfolio:ready', async () => {
        build();

        const section = document.querySelector('#portfolio section[data-section=Writer]');
        const mainContent = document.querySelector('#portfolio section[data-section=Writer] #description');

        const viewPane = document.createElement('span');
        viewPane.style.width = '100%';
        viewPane.style.height = `${blocks.height + 100}px`;
        viewPane.id = 'viewPane';
        if (!document.querySelector('#portfolio section #viewPane')) {
            mainContent.before(viewPane);
        }

        let set = false;
        function setUp() {
            if (!set) {
                if(section.getBoundingClientRect().height > 0){
                    scrollState = openState;
                    animationState = textAnimation;
                    set = true;
                }
            } else {
                if(section.getBoundingClientRect().height > 0){
                    container.addChild(blocks);
                    scrollState = openState;
                    animationState = textAnimation;
                }
            }
        }

        const startSate = (delta) => {
            let a = mainContent.getBoundingClientRect().top - 50 - blocks.height ;
            cover.y = a;
        }

        const openState = (delta) => {
            let a = mainContent.getBoundingClientRect().top - 50 - blocks.height;
            blocks.y = a;
        }

        function remove() {
            container.removeChildren();
            scrollState = nullState;
            animationState = nullState;
            transitionState = nullState;
        }

        function removeListeners() {
            listener.remove(section, 'transitionend', setUp);
            listener.remove(document, 'portfolio.opening', opening);
            listener.remove(document, 'portfolio.closing', remove);
        }

        function removeReset() {
            remove();
            reset();
            removeListeners();
        }

        let alphabet = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        let a = 0;
        let index = 0;
        let count = 0;
        let end = pTitle.length;
        function textAnimation(delta) {
            count++;

            if (a === end) {
                animationState = nullState;
            }

            if ((count % 2) === 0) {            
                count = 0;
                let l = alphabet[index];
                pTitle[a].text = l;
                if (l === title[a]) {
                    a++;
                    index = 0;
                }
                index++;
            }
        }

        let ran = false;
        function trigger() {
            if(!ran) {
                blocks.y = cover.y;
                container.addChildAt(blocks,0);
                transitionState = openState;
                animationState = reveal;
                ran = true;
            }
        }

        let i = 0;
        let x = cover.children.length;
        let current = 0;
        let speed = 0.5;
        async function reveal(delta) {
            const block = cover.children[i];
            current += speed * delta.deltaTime;
            block.rotation -= current * delta.deltaTime;
            block.alpha -= speed * delta.deltaTime;
            if (current >= 1) {
                i++;
                current = 0;
            }
            if (i === x) {
                await pixi.removeChild(cover);
                transitionState = nullState;
                scrollState = openState;
                animationState = textAnimation;
            }
        }

        function opening(e) {
            if (e.detail.name !== 'Writer') {
                remove();
            }
        }
    
        listener.add(section, 'transitionend', setUp);
        listener.add(document, 'portfolio.opening', opening);
        listener.add(document, 'portfolio.closing', remove);
        listener.add(document, 'portfolio:off', removeReset, {once: true});
    });
});