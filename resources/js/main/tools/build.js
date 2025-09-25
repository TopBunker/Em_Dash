import {autoDetectRenderer, BitmapText, Graphics, Sprite, Container, Assets} from "pixi.js";
import {grid} from "./grid";

/**
 * -BUILD 
 * Page construction helper functions 
 */

/**
 * Append and position HTML elements to page
 * @param {object} tagListObject object containing element nodes as values 
 */
function domMedia(tagListObject){
  let dbg = document.getElementById("dom");
  let vals = Object.values(tagListObject);
  let element = vals[0];
  dbg.appendChild(element);
  if(vals.length > 1){
    for(let i = 1; i < vals.length; i++){
      let el = vals[i];
      let vOffset = (parseInt(dbg.lastElementChild.style.top, 10) + dbg.lastElementChild.scrollHeight + 20);
      el.style.top = `${vOffset}px`;
      dbg.appendChild(el);
    }
  }
}

/**
 * Create a scaled Pixijs Sprite object from an image
 * @param {string} texture texture to return as Pixijs Sprite, scaling as necessary
 * @param {string} scale "full" (fullscreen default), "half", "third", "thumbnail"
 * @param {number} width width of the returned Sprite object; scale factor relative to main panel width if not provided
 * @param {numbr} height height of the returned Sprite object; scaled according to width if not provided
 * @returns {Promise<Sprite>} Pixijs Sprite Object scaled to specified dimensions (or fullscreen by default)
 */
async function makeSprite(texture, width, height, scale){
  scale = scale ? scale : "full";

  let targetWidth = width ? width : document.getElementById("gridPanel").clientWidth;
  let targetHeight = height ? height : document.getElementById("gridPanel").clientHeight;

  switch (scale) {
    case "half":
      targetWidth /= 2;
      targetHeight /= 2;
      break;

    case "third":
      targetWidth /= 3;
      targetHeight /= 3;
      break;

    case "thumb": 
      targetWidth /= 4;
      targetHeight /= 4;
      break;

    default:
    break;
  }
  
  let i = await autoScaler(texture, targetWidth);
  let t = await Assets.load(i);
  return Sprite.from(t);
}

/**
 * Scale image through multiple-step bilinear interpolation via Canvas API to counter quality loss 
 * @param {string} texture image to scale as Pixijs Texture
 * @param {number} targetWidth target width
 * @param {number} targetHeight target height 
 * @returns {string} url referencing the scaled image
 */
async function autoScaler(texture, targetWidth, targetHeight){
  const con = new Container();
  const i = Sprite.from(texture);
  con.addChild(i);
  const render = await autoDetectRenderer({width: i.width, height: i.height});
  render.render(con);

  let c = render.canvas;
  c.getContext("2d");
  c.imageSmoothingEnabled = false;
  let w = c.width;
  let h = c.height;

  let scale  = targetWidth / w;

  let steps = Math.abs(Math.ceil(Math.log(w/targetWidth)*Math.log(scale)));

  steps =  3;

  scale = Math.pow(scale, 1 / (steps));

  let canvas = document.createElement("canvas");
  let ctx = canvas.getContext("2d");
  ctx.imageSmoothingEnabled = false;
  canvas.width = w * scale;
  canvas.height = h * scale;

  ctx.drawImage(c, 0, 0, canvas.width, canvas.height);

  if (steps > 2) {
    for (let index = 2; index < steps; index++) {
      ctx.drawImage(canvas, 0, 0, Math.floor(w * Math.pow(scale, (index - 1))), Math.floor(h * Math.pow(scale, (index - 1))), 
                            0, 0, Math.floor(w * Math.pow(scale,  index)), Math.floor(h * Math.pow(scale, index)));
    }
  }

  let finalCan = document.createElement("canvas");
  let fctx = finalCan.getContext("2d");
  finalCan.imageSmoothingEnabled = false;

  finalCan.width = targetWidth;
  finalCan.height = targetHeight ? targetHeight : Math.floor(h * Math.pow(scale, (steps - 1)));

  fctx.drawImage(canvas, 0, 0, Math.floor(w * Math.pow(scale, (steps - 1))), Math.floor(h * Math.pow(scale, (steps - 1))), 
                         0, 0, finalCan.width, finalCan.height);

  return finalCan.toDataURL("image/png", 1);  
}

/**
 * Create Pixijs BitmapText object from given string
 * @param {string} str string to convert to Pixijs BitmapText object    
 * @param {Object} font object containing font details
 * @returns {BitmapText} Pixijs BitmapText
 */
function makeText(str, font) {
  const text = new BitmapText({text: str, style: {fontFamily:"Poppins", fontSize: font.size, fill: 0x000000, align: "center"}});
  return text;
}

/**
 * Convert string to a Pixijs BitmapText object
 * @param {string} str string to be converted to Pixijs BitmapText objects
 * @param {number} cut pixification method 0: as a single text object to be manipulated as a group, 1: split by white space, 2: each character
 * @returns {Array<BitmapText>} array with with single string or string components as Pixijs BitmapText objects
 */
function pixifyText(str,cut,font){
  let f = font ? font : {size:32};
  let pixified = [];
  switch (cut) {
    case 0:
      pixified.push(makeText(str,f));
      break;
    case 1:
      let a = str.split(" ");
      a.forEach(s => {pixified.push(makeText(s,f))});
      break;
    case 2:
      //split string by characters, removing whitespace
      let c = str.replaceAll(/ /g,"");  
      let b = c.split("");
      b.forEach(s => {pixified.push(makeText(s,f))});
      break;
    default:
      break;
  }
  return pixified;
}

/**
 * Create a Pixijs graphics object the shape and size of a canvas grid block
 * @param {color} c block border color
 * @param {number} x block column
 * @param {number} y block row
 * @returns {Graphics} Pixijs Graphics object
 */
function block(c, x, y){
  let tile = grid[x][y];
  let shape = new Graphics();
  shape.rect(tile.x, tile.y, tile.width, tile.height);
  shape.stroke(c);
  return shape;
}

export {pixifyText, block, makeText, domMedia, makeSprite}; 