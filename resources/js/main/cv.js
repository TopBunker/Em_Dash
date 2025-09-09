import {Application, Container, Ticker} from "pixi.js";

/**
 * Pixijs containers for adding canvas elements
 * @type {Container}
 */
const background = new Container();
const main = new Container();

 /**
     *  Pixijs Application
     * @type {Application}
     * interface for Pixijs canvas
     */
    const app = new Application();

$(async () =>
{ 
    /**
     * DOM elements
     * @type {Element}
     */
    const canDiv = document.getElementById('canvas');

    await app.init({
        backgroundAlpha: 1, 
        backgroundColor:'#fce7f3',
        powerPreference: "high-performance",
        width: window.innerWidth,
        height: window.innerHeight,
        resizeTo: window,
        autoDensity: true,
        antialias: false,
        resolution: window.devicePixelRatio,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: "high"
    }); 
    // add canvas to dom
    canDiv.appendChild(app.canvas);


    // add containers to canvas
    app.stage.addChild(main);

  
    //app.ticker.add((delta)=>{update(delta)});

});

/**
 * TICKER
 */

let state = rest;

function update(delta){
  delta.autoStart = false;
  state(delta);

}

function rest(delta){
  delta.start();
}