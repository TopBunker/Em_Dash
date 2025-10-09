import { Container, Graphics, Sprite, DisplacementFilter, Assets, FillGradient, Filter, GlProgram } from "pixi.js";
import { makeText} from "./tools/build.js";
import { gridify, setGrid } from "./tools/grid.js";

/**
 * Pixijs containers for adding canvas elements
 * @type {Container}
 */
const main = new Container();
const portfolio = new Container();
const background = new Container();

let mainState, bgState;

$(async () => {

  const pixi = Alpine.store('app').pixi; 
  await pixi.ready;

  await pixi.addChildAt(background, 0);
  await pixi.addChild(portfolio, 1);
  await pixi.addChildAt(main, 2);

  const listener = Alpine.store('app').listeners;

  /**
   * HEADER - Main
   */
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

  const headerBg = new Graphics();
  headerBg.circle(window.innerWidth/2, window.innerHeight/4.2, window.innerWidth);
  headerBg.fill({fill: radialGradient});

  const hBg = new Graphics();
  hBg.rect(0,0,window.innerWidth,window.innerHeight/4.2);
  hBg.fill({color: '0xffffff'});

  const rt = pixi.app.renderer.textureGenerator.generateTexture(headerBg);
  const hTex = pixi.app.renderer.textureGenerator.generateTexture(hBg);

  const headSprite = new Sprite(tex);
  headSprite.width = window.innerWidth;
  headSprite.height = window.innerHeight/4.2;

  const headBack = new Sprite(hTex);
  headBack.width = window.innerWidth;
  listener.add(document.querySelector('header div'), 'getHeight', () => {
  headBack.height = Alpine.store('app').headHeight;});

  main.addChild(headSprite, headBack);

  const dispSprite = new Sprite(rt);
  dispSprite.width = window.innerWidth;
  dispSprite.height = window.innerHeight/4.2;
  main.addChild(dispSprite);

  const dispFilter = new DisplacementFilter({ sprite: headSprite });
  dispFilter.scale.set(5);
  dispSprite.filters = [dispFilter];

  let xR = 0;
  let yR = 0;
  let bW = window.innerWidth/2;

  /**
   * BACKGROUND
   */
  const gradient = new FillGradient({
    type: 'linear',
    start: { x: 0, y: 1 },
    end: { x: 0, y: 0 },
    colorStops: [
        { offset: 0, color: '0xffffff' },
        { offset: 1, color: '0x0000ff' },
    ],
    textureSpace: 'local'
  });

  const vertexShader = `
    in vec2 aPosition;
    out vec2 vTextureCoord;

    uniform vec4 uInputSize;
    uniform vec4 uOutputFrame;
    uniform vec4 uOutputTexture;

    void main(void) {
        gl_Position = vec4(aPosition * 2.0 - 1.0, 0.0, 1.0);
        vTextureCoord = aPosition;
    }`;

  const fragmentShader = `
    in vec2 vTextureCoord;

    uniform sampler2D uTexture;
    uniform float uWaveAmplitude;
    uniform float uWaveFrequency;
    uniform float uTime;

    void main(void) {
        vec2 coord = vTextureCoord;

        coord.x += sin(coord.y * uWaveFrequency + uTime) * uWaveAmplitude;

        gl_FragColor = texture(uTexture, coord);
    }`;

  const gradientFilter = new Filter({
    glProgram: new GlProgram({vertex: vertexShader, fragment: fragmentShader}),
    resources: {
        waveUniforms: {
            uWaveAmplitude: { value: 0.05, type: 'f32' },
            uWaveFrequency: { value: 10.0, type: 'f32' },
            uTime: { value: 0.0, type: 'f32' }
        }
    }
  });

  const bg = new Graphics();
  bg.rect(0,0,window.innerWidth,window.innerHeight);
  bg.fill({fill: gradient});

  let bgTexture = pixi.app.renderer.textureGenerator.generateTexture(bg);
  
  const bgSprite = new Sprite(bgTexture);
  bgSprite.width = window.innerWidth;
  bgSprite.height = window.innerHeight;
  bgSprite.x = 0;
  bgSprite.y = 0;
  bgSprite.alpha = 0.1;
  bgSprite.filters = [gradientFilter];

  /**
   * TICKER - Main
   */
  await pixi.addTicker((delta) => {
    mainState(delta);
    bgState(delta);
  });

  main._animationHandler = (delta) => {
    xR += 0.002;
    yR += 0.005;
    // Ripple/wave effect → scroll texture
    dispSprite.x = bW * Math.sin(xR);
    dispSprite.y = 14 * Math.cos(yR);

    // Heat haze effect → oscillate scale
    dispFilter.scale.x = 5 + Math.sin(delta.lastTime * 0.001) * 100;
    dispFilter.scale.y = 5 + Math.cos(delta.lastTime * 0.001) * 75;
  }

  background._animationHandler = (delta) => {
    gradientFilter.resources.waveUniforms.uniforms.uTime += 0.02 * delta.deltaTime;
  }

  mainState = main._animationHandler;
  bgState = background._animationHandler;

  /**
   * PORTFOLIO 
   */
  const nodeGradient = new FillGradient({
    type: 'radial',
    center: { x: 0.5, y: 0.5 },
    innerRadius: 0,
    outerCenter: { x: 0.5, y: 0.5 },
    outerRadius: 0.5,
    colorStops: [
        { offset: 0, color: '0xffffff' },
        { offset: 0.9, color: '0x0000ff' },
        { offset: 1, color: '0xffffff' },
    ],
    textureSpace: 'local'
  });

  listener.add(document, 'portfolio:ready', async () => {
    background.addChild(bgSprite);
    const links = document.querySelectorAll('#portfolio nav a');

    let buttonState; // manage button animation
    await pixi.addTicker((delta) => {
      buttonState(delta);
    });

    setGrid();

    // create button nodes as background canvas elements
    let nodes = {};
    let col = 2;
    let row = 5;
    links.forEach(link => {
      listener.add(link, 'click', toggleNode);
      let text = link.textContent.trim();
      let c = new Container();
      let t = makeText(text, {size: 20});
      Object.assign(t.style, {wordWrap: true, wordWrapWidth: 100});
      t.anchor.set(0, 0.5);
      let n = new Graphics();
      n.circle((t.x+(t.width/2)), t.y, 90);
      n.fill({fill: nodeGradient});
      let texture = pixi.app.renderer.textureGenerator.generateTexture(n);
      let s = new Sprite(texture);
      s.alpha = 0.2;
      s.anchor.set(0.5);
      s.x = (t.x+(t.width/2));
      s.y = t.y;
      c.addChildAt(s, 0);
      c.addChildAt(t, 1);
      let cxy = gridify(c, col, row);
      nodes[text.replace(/\s/g,'').toLowerCase()] = {text: text, button: link, node: cxy, open: false, origin: {x: cxy.x, y: cxy.y}};
      col+=3;
      // task: extend for links.length > 2 
    });


    // register clicks on button nodes
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
          listener.remove(window,'click',nodeClicked);
          buttonState = () => {};
          link.button.click();
          break;
        }
      }
    }
    listener.add(window, 'click', nodeClicked);

    // buttonnodes onClick()
    let portfolioOpen = false;
    function toggleNode(event){
      let parent = document.querySelector('#portfolio');
      let section = event.target.textContent.trim(); // get section clicked
      let key = section.replace(/\s/g,'').toLowerCase();
      let link = nodes[key];
      if (link.open) {
        // if open link is clicked, close all sections
        for (const key in nodes) {
          if (!Object.hasOwn(nodes, key)) continue;
          const l = nodes[key];
          l.open = false;  
        }
        buttonState = moveToOrigin;
        Alpine.$data(parent).section = ''; // trigger x-show
        portfolioOpen = false;
        document.dispatchEvent(new Event('portfolio.closing'));
      } else {
        document.querySelector('main').scrollTop = 0;
        // open/switch section
        Alpine.$data(parent).section = section; // trigger x-show
        if(!portfolioOpen) {
          // if portfolio is not set to open and current clicked link is closed then open portfolio, else switch 
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
          listener.add(window,'click',nodeClicked);
        }
        link.open = true;
        portfolioOpen = true;
        document.dispatchEvent(new CustomEvent('portfolio.opening', {detail: {name: link.text}}));
      }
    }

    // add button nodes to screen
    for (const key in nodes) {
      if (!Object.hasOwn(nodes, key)) continue;
      const button = nodes[key];
      portfolio.addChild(button.node);
    }

    // Ticker callbacks
    // move nodes on click
    async function moveTo(obj, endX = obj.x, endY = obj.y, scale = 1) {
      if (!obj) {
        console.error('No object to move.');
        return;
      }

      if (obj._animationHandler) {
        await pixi.removeTicker(obj._animationHandler);
      }

      let dX = Math.abs(endX - obj.x);
      let dY = Math.abs(endY - obj.y);
      let dSx = Math.abs(scale - obj.scale.x);
      let dSy = Math.abs(scale - obj.scale.y);
      let steps = 30;

      obj._animationHandler = async (delta) => {
        if ((obj.x === endX) && (obj.y === endY)) {
          await pixi.removeTicker(obj._animationHandler);
          obj._animationHandler = null;
          listener.add(window,'click',nodeClicked);
        }
        if (obj.x > endX) {
          obj.x -= ((dX/steps) * delta.deltaTime);
          if (obj.x < endX) {
            obj.x = endX;
          }
        }
        if (obj.x < endX) {
          obj.x += ((dX/steps) * delta.deltaTime);
          if (obj.x > endX) {
            obj.x = endX;
          }
        }
        if (obj.y > endY) {
        obj.y -= ((dY/steps) * delta.deltaTime);
        if (obj.y < endY) {
          obj.y = endY;
          }
        }
        if (obj.y < endY) {
          obj.y += ((dY/steps) * delta.deltaTime);
          if (obj.y > endY) {
            obj.y = endY;
          }
        }
        if (obj.scale.x < scale || obj.scale.y < scale) {
          obj.scale.x += (dSx/steps * delta.deltaTime);
          obj.scale.y += (dSy/steps * delta.deltaTime);
          if (obj.scale.x > scale || obj.scale.y > scale){
            obj.scale.set(scale, scale);
          }
        }
        if (obj.scale.x > scale || obj.scale.y > scale) {
          obj.scale.x -= (dSx/steps * delta.deltaTime);
          obj.scale.y -= (dSy/steps * delta.deltaTime);
          if (obj.scale.x < scale || obj.scale.y < scale ){
            obj.scale.set(scale, scale);
          }
        }
      }

      await pixi.addTicker(obj._animationHandler);

      // animate background
      if(bgSprite._animationHandler){
        await pixi.removeTicker(bgSprite._animationHandler);
      }
      bgSprite._animationHandler = (delta) => {
        if (obj.y > endY) {
          bgSprite.y += (dY/steps * delta.deltaTime);
        }
        if (obj.y < endY) {
          bgSprite.y -= (dY/steps * delta.deltaTime);
        }
      }
    }

    let steps = 15;
    let scale = 1;
    let keys = Object.keys(nodes);
    const closeEnough = (a, b, e = 1) => {return Math.abs(a - b) < e ? true : false};
    function moveToOrigin(delta) {
      for (let i = 0; i < keys.length; i++) {
        const key = keys[i];
        const obj = nodes[key].node;
        let endX = nodes[key].origin.x;
        let endY = nodes[key].origin.y;
        let dX = Math.abs(endX - obj.x);
        let dY = Math.abs(endY - obj.y);
        let dSx = Math.abs(scale - obj.scale.x);
        let dSy = Math.abs(scale - obj.scale.y);
        if (closeEnough(obj.x, endX) && closeEnough(obj.y, endY)) {
          obj.x = endX;
          obj.y = endY;
          obj.scale.set(1);
          obj.zIndex = i;
          if (i === (keys.length - 1)) {
            startMorph();
            listener.add(window,'click',nodeClicked);
          }
        }
        if (obj.x > endX) {
          obj.x -= ((dX/steps) * delta.deltaTime);
          if (obj.x < endX) {
            obj.x = endX;
          }
        }
        if (obj.x < endX) {
          obj.x += ((dX/steps) * delta.deltaTime);
          if (obj.x > endX) {
            obj.x = endX;
          }
        }
        if (obj.y > endY) {
        obj.y -= ((dY/steps) * delta.deltaTime);
        if (obj.y < endY) {
          obj.y = endY;
          }
        }
        if (obj.y < endY) {
          obj.y += ((dY/steps) * delta.deltaTime);
          if (obj.y > endY) {
            obj.y = endY;
          }
        }
        if (obj.scale.x < scale || obj.scale.y < scale) {
          obj.scale.x += (dSx/steps * delta.deltaTime);
          obj.scale.y += (dSy/steps * delta.deltaTime);
          if (obj.scale.x > scale || obj.scale.y > scale){
            obj.scale.set(scale, scale);
          }
        }
        if (obj.scale.x > scale || obj.scale.y > scale) {
          obj.scale.x -= (dSx/steps * delta.deltaTime);
          obj.scale.y -= (dSy/steps * delta.deltaTime);
          if (obj.scale.x < scale || obj.scale.y < scale ){
            obj.scale.set(scale, scale);
          }
        }     
      }   
    }

    // morph nodes
    let x = 0.001;
    let t = 0;
    function morphing(delta) {
      t = (t + delta.elapsedMS) % 60000;
      for (const key in nodes) {
        if (!Object.hasOwn(nodes, key)) continue;
        const obj = nodes[key].node;
        obj.scale.set(1 + (Math.sin(t * x) * 0.1));
        obj.zIndex = Math.sin(t * x) * 1000;
        x = x * -1;
      }
    }

    function startMorph () {
      x = 0.001; 
      t = 0;
      buttonState = morphing;
    } startMorph();

    listener.add(document, 'portfolio:off', () => {
        buttonState = () => {};
        portfolio.removeChildren();
        listener.remove(window,'click',nodeClicked);
    }, {once: true});

  });


   /**
   * ADDITIONAL LISTENERS 
   */

  listener.add(document, 'contact:ready', () => {
    background.addChild(bgSprite);
  });

  listener.add(document, 'resume:ready', () => {
    background.removeChild(bgSprite);
  });

  // signal ready when page initializes
  if (Alpine.store('app').currentPage === 'portfolio') {
      document.dispatchEvent(new Event('portfolio:ready'));
  }

  if (Alpine.store('app').currentPage === 'contact') {
      document.dispatchEvent(new Event('contact:ready'));
  }

  if (Alpine.store('app').currentPage === 'resume') {
      document.dispatchEvent(new Event('resume:ready'));
  }
  
});



 