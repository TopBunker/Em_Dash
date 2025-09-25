import { Application, Container, Graphics, Sprite, DisplacementFilter, Assets, FillGradient, Text, TextStyle, BitmapText } from "pixi.js";
import { makeText} from "./tools/build.js";
import { gridify, setGrid } from "./tools/grid.js";

/**
 * Pixijs containers for adding canvas elements
 * @type {Container}
 */
const main = new Container();
const portfolio = new Container();


let isActive = false;

/**
  *  Pixijs Application
  * @type {Application}
  * interface for Pixijs canvas
  */
//const app = new Application();

$(async () => {

  const canDiv = document.querySelector('#canvas');
/** 
  await app.init({
    backgroundAlpha: 0, 
    powerPreference: 'high-performance',
    width: window.innerWidth,
    height: window.innerHeight,
    resizeTo: window,
    autoDensity: true,
    antialias: false,
    resolution: window.devicePixelRatio,
    imageSmoothingEnabled: true,
    imageSmoothingQuality: "high",
  });    */

  const app = Alpine.store('app').pixi; //pass app to global variable for referencing

  //canDiv.appendChild(app.canvas);

  //HEADER

  const tex = await Assets.load('/storage/images/system/waves/crumpled-fabric-wave.jpg');

  const radialGradient = new FillGradient({
    type: 'radial',
    center: { x: 0.5, y: 0.5 },
    innerRadius: 0,
    outerCenter: { x: 0.5, y: 0.5 },
    outerRadius: 0.5,
    colorStops: [
        { offset: 0, color: '0x0000ff' },
        { offset: 0.5, color: '0xffff00' },
        { offset: 0.6, color: '0xffffff' },
        { offset: 1, color: '0xffffff' }   
    ],
    textureSpace: 'local'
  });

  const bg = new Graphics();
  bg.circle(window.innerWidth/2, window.innerHeight/2, window.innerHeight > window.innerWidth ? window.innerHeight : window.innerWidth);
  bg.fill({fill: radialGradient});

  const rt = app.application.renderer.textureGenerator.generateTexture(bg);

  const headSprite = new Sprite(tex);
  headSprite.width = window.innerWidth;
  headSprite.height = window.innerHeight/4.2;
  main.addChild(headSprite);

  const dispSprite = new Sprite(rt);
  dispSprite.width = window.innerWidth;
  dispSprite.height = window.innerHeight/4.2;
  main.addChild(dispSprite);

  const dispFilter = new DisplacementFilter({ sprite: headSprite });
  dispFilter.scale.set(5);
  dispSprite.filters = [dispFilter];

  app.addChild(main);

  let xR = 0;
  let yR = 0;
  let bW = window.innerWidth/2;
  app.addTicker((delta) => {
    xR += 0.002;
    yR += 0.005;
    // Ripple/wave effect → scroll texture
    dispSprite.x = bW * Math.sin(xR);
    dispSprite.y = 14 * Math.cos(yR);

    // Heat haze effect → oscillate scale
    dispFilter.scale.x = 5 + Math.sin(delta.lastTime * 0.001) * 100;
    dispFilter.scale.y = 5 + Math.cos(delta.lastTime * 0.001) * 75;
  });

  // PORTFOLIO PAGE
  
  const gradient = new FillGradient({
    type: 'radial',
    center: { x: 0.5, y: 0.5 },
    innerRadius: 0,
    outerCenter: { x: 0.5, y: 0.5 },
    outerRadius: 0.5,
    colorStops: [
        { offset: 0.3, color: '0xffffff' },
        { offset: 0.9, color: '0xd3d3d3' },
        { offset: 1, color: '0x000000' },
    ],
    textureSpace: 'local'
  });

  document.addEventListener('portfolio:ready', () => {
    const links = document.querySelectorAll('#portfolio nav a');

    setGrid();

    /**
     * Portfolio Page Start
     */

    let nodes = {};
    let col = 2;
    let row = 5;
    links.forEach(link => {
      link.addEventListener('click', toggleNode);
      let text = link.textContent.trim();
      let c = new Container();
      c.interactive = true;
      let t = makeText(text,{size:20});
      Object.assign(t.style,{wordWrap: true, wordWrapWidth: 100});
      t.anchor.set(0, 0.5);
      let n = new Graphics();
      n.circle(((t.x+t.width)/2), t.y, 100);
      n.fill({fill: gradient});
      c.addChildAt(n,0);
      c.addChildAt(t,1);
      let cxy = gridify(c,col,row);
      nodes[text.replace(/\s/g,'').toLowerCase()] = {name: text, button: link, node: cxy, open: false, origin: {x: cxy.x, y: cxy.y}};
      col+=3;
    });

    // register clicks on background canvas element
    const nodeClicked = (e) => {
      const x = e.clientX;
      const y = e.clientY;
      for (const key in nodes) {
        if (!Object.hasOwn(nodes, key)) continue;
        const link = nodes[key];
        let b = link.node.getBounds(true);
        let xStart = b.x;
        let xEnd = xStart + b.width;
        let yStart = b.y;
        let yEnd = yStart + b.height;
        if(((x >= xStart) && (x <= xEnd)) && ((y >= yStart) && (y <= yEnd))){
          link.button.click();
          break;
        }
      }
    }

    let portfolioOpen = false;
    function toggleNode(event){
      let parent = document.querySelector('#portfolio');
      let section = event.target.textContent.trim();
      let key = section.replace(/\s/g,'').toLowerCase();
      let link = nodes[key];
      if (link.open) {
        // if open section link is clicked, close all sections
        for (const k in nodes) {
          if (!Object.hasOwn(nodes, k)) continue;
          const l = nodes[k];
          moveTo(l.node, l.origin.x, l.origin.y);
          l.open = false;
        }
        Alpine.$data(parent).section = ''; // trigger x-show
        portfolioOpen = false;
        document.dispatchEvent(new Event('portfolio.closing'));
      } else {
        // open/switch section
        Alpine.$data(parent).section = section; // trigger x-show
        if(!portfolioOpen){
          //if portfolio is open and current clicked link is closed then switch, else open portfolio
          let s = 0.3; // scale
          for (const k in nodes) {
            if (!Object.hasOwn(nodes, k)) continue;
            const l = nodes[k];
            l.open = false;
            let LContent = 0;
            let RContent = window.innerWidth - (l.node.children[1].width * s);
            let y = l.node.y + 180;
            if (window.innerWidth >= 768) {
              s = 0.4;
              const leftCol = document.querySelector('#portfolio #left-col');
              const rightCol = document.querySelector('#portfolio #right-col');
              LContent = 50;
              RContent = window.innerWidth - (l.node.width * s);
              y = window.innerHeight - 100;
            }
            if (l.node.x < window.innerWidth/2){
              moveTo(l.node, LContent, y, s);
            } else {
              moveTo(l.node, RContent, y, s);
            }
          }

        } else {
          for (const k in nodes) {
            if (!Object.hasOwn(nodes, key)) continue;
            const l = nodes[k];
            l.open = false;
          }
        }
        link.open = true;
        portfolioOpen = true;
        document.dispatchEvent(new CustomEvent('portfolio.opening',{detail: {name: link.text}}));
      }
    }

    window.addEventListener('click', nodeClicked);

    for (const key in nodes) {
      if (!Object.hasOwn(nodes, key)) continue;
      const element = nodes[key];
      portfolio.addChild(element.node);
    }

    app.addChild(portfolio);
    app.render();

    // Ticker callbacks
    function pTicker(nodes, dt) {
    }

    let t = 30;
    function moveTo(obj, endX, endY, scale) {
      window.removeEventListener('click', nodeClicked);
      if (!obj) {
        console.error('No object to move'); 
        return;
      }
      if (endX === undefined) {
        endX = obj.x;
      }
      if (endY === undefined) {
        endY = obj.y;
      }
      if (scale === undefined) {
        scale = 1;
      }
      let dX = Math.abs(endX - obj.x);
      let dY = Math.abs(endY - obj.y);
      let dSx = Math.abs(scale - obj.scale.x);
      let dSy = Math.abs(scale - obj.scale.y);
      function animate(delta) {
        if (obj.x === endX && obj.y === endY) {
          app.removeTicker(animate);
          window.addEventListener('click', nodeClicked);
        }
        if (obj.x > endX) {
          obj.x -= ((dX/t) * delta.deltaTime);
          if (obj.x < endX) {
            obj.x = endX;
          }
        }
        if (obj.x < endX) {
          obj.x += ((dX/t) * delta.deltaTime);
          if (obj.x > endX) {
            obj.x = endX;
          }
        }
        if (obj.y > endY) {
        obj.y -= ((dY/t) * delta.deltaTime);
        if (obj.y < endY) {
          obj.y = endY;
          }
        }
        if (obj.y < endY) {
          obj.y += ((dY/t) * delta.deltaTime);
          if (obj.y > endY) {
            obj.y = endY;
          }
        }
        if (obj.scale.x < scale && obj.scale.y < scale) {
          obj.scale.x += (dSx/t * delta.deltaTime);
          obj.scale.y += (dSy/t * delta.deltaTime);
          if (obj.scale.x > scale && obj.scale.y > scale){
            obj.scale = scale;
          }
        }
        if (obj.scale.x > scale && obj.scale.y > scale) {
          obj.scale.x -= (dSx/t * delta.deltaTime);
          obj.scale.y -= (dSy/t * delta.deltaTime);
          if (obj.scale.x < scale && obj.scale.y < scale ){
            obj.scale = scale;
          }
        }

      }
      app.addTicker(animate);
    }

    document.addEventListener('portfolio:off', () => {
        portfolio.removeChildren();
        app.removeChild(portfolio);
        window.removeEventListener('click',nodeClicked);
    }, {once: true});

  });

  // signal ready when page initializes
  if (Alpine.store('app').currentPage === 'portfolio') {
      document.dispatchEvent(new Event('portfolio:ready'));
  }
  
});



 