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
        backgroundColor:'pink',
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

    canDiv.appendChild(app.canvas);

    

    //add containers to canvas
    app.stage.addChild(main);

    //console.log(contact.style);
    //const cntctNode = new Node(['cMeet','cProject','cConnect'], contact.offsetLeft+(contact.offsetWidth/2), contact.offsetTop+(contact.offsetHeight/2), (contact.offsetWidth/2)+(contact.offsetWidth/4),  'blue');
    //main.addChild(cntctNode.node);

    /**const abt = new Node('About Me',['this is the data contained in the node'], [], window.innerWidth/2, window.innerHeight/2, window.innerWidth/3, "#7FFF00");
     main.addChild(abt.node);

    const port = new Node('Portfolio',['this is the data contained in the node'], [], window.innerWidth/3, window.innerHeight/1.3, window.innerWidth/3, "#7FFF00");
    main.addChild(port.node);*/

    //initialise Pixijs ticker
    app.ticker.add((delta)=>{update(delta)});

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