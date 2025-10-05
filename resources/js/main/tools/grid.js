/**
 * GRID SYSTEM 
 */

/**
 * -Window Grid 
 * @returns {Object[]} grid coordinates top left to bottom right; [col][row].property
 */
function gridCoordinates(){
  let refWidth = window.innerWidth/9;
  let refHeight = window.innerHeight/9;

  let grd = [];
  let scale = (2 * window.innerWidth) < window.innerHeight ? 1 : 0.75;
  scale = window.innerWidth >= 1919 ? 2 : (window.innerWidth >= 768 ? 1 : scale);
  
  let count = 0;

  while (count < 9) {
    let col = [];
  
    for (let index = 0; index < 9; index++) {
      let tile = {
        x: refWidth * count,
        y: refHeight * index,
        width: refWidth,
        height: refHeight,
        scale: scale
      } 
      col.push(tile);
    }
  
    grd.push(col);
  
    count++;
  }
  
  return grd;
}

let grid = [];  // object Array of 81 (9/9) coordinate objects defining the grid system;  acccessed: grid[col][row]
const setGrid = () => {grid = gridCoordinates();};
setGrid();

/**
 * 
 * @param {*} w :grid width
 * @param {*} h :grid height
 * @param {*} c :number of columns
 * @param {*} r :number of rows
 * @returns {Object[]} grid coordinates top left to bottom right; [col][row].property
 */
function makeGrid(w, h, c, r){
  let grd = [];
  let refW = w/c;
  let refH = h/r;
  
  let count = 0;

  while (count < c) {
    let col = [];
  
    for (let index = 0; index < r; index++) {
      let tile = {
        x: refW * count,
        y: refH * index,
        width: refW,
        height: refH,
      } 
      col.push(tile);
    }
  
    grd.push(col);
  
    count++;
  }
  
  return grd;
}


/**
 * quadrant
 * @param {Array[]} tiles  :7x7 Array[] of Pixi Containers
 * @returns {Object} :object of Pixi Containers divided into four dimensions: twoxtwo, horizontal centre, vertical centre and centre
 */
function quadrant(){    
  let xFactor = window.innerWidth < window.innerHeight ? 0.05 : 0.15;
  let yFactor = window.innerWidth < window.innerHeight ? 0.1 : 0.08;
  let xStrt = () => window.innerWidth < window.innerHeight ? xFactor * window.innerWidth : xFactor * window.innerHeight; 
  let yStrt = () => window.innerWidth < window.innerHeight ? yFactor * window.innerHeight : yFactor * window.innerWidth; 

  let grd = {tbt: tbt, cross: cross};
    
  let tbt = {
    tl: {
      x: xStrt,
      y: 0,
      width: 100 / 2,
      height: 100 / 2
    },
    tr: {
      x: xStrt + 100,
      y: 0,
      width: 100 / 2,
      height: 100
    },
    bl: {
      x: xStrt,
      y: 100,
      width: 100,
      height: 100
    },
    br: {
      x: xStrt + 100,
      y: 100,
      width: 100,
      height: 100
    }
  }
    
  let cross = {
    lat: {
      x: xStrt + (100 * 4),
      y: 0,
      width: 100,
      height: 100
    },
    horizon: {
      x: xStrt,
      y: 100,
      width: 100,
      height: 100
    }
  }

  return grd;
}

    
/**
 * GRIDIFY
 * @param {Object} a :image, text...
 * @param {number} col :x position
 * @param {number} row :y position
 * @returns :updates the coordinates of the recieved object and returns the reference
 */
function gridify(a, col, row){
  let d = grid[col][row];
  a.x = Math.round(d.x);
  a.y = Math.round(d.y);
  return a;
}

function altGridify(altGrid, a, col, row){
  let d = altGrid[col][row];
  a.x = Math.round(d.x);
  a.y = Math.round(d.y);
  return a;
}
  
function gridifyCenter(a, col, row){
  let d = grid[col][row];
  a.anchor.set(0.5);
  a.x = Math.round(d.x) + (d.width / 2);
  a.y = Math.round(d.y) + (d.height / 2);
  return a;
}

function altGridifyCenter(altGrid, a, col, row){
  let d = altGrid[col][row];
  a.anchor.set(0.5);
  a.x = Math.round(d.x) + (d.width / 2);
  a.y = Math.round(d.y) + (d.height / 2);
  return a;
}

function centerPage(a, col, row){
  let d = grid[col][row];
  a.anchor.set(0.5);
  a.x = outer.clientWidth / 2;
  a.y = outer.clientHeight  / 2;
}

function scaleToCanvas(element){
  let width = element.width;
  let ref = outer.clientWidth - (0.05 * outer.clientWidth);
  element.scale.x *= ref/width;
  element.scale.y *= ref/width;
}

function gridScale(element, scale, width, height){
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

  let s  = targetWidth / element.width;
  
  element.scale = s;
}

export {gridify, altGridify, gridifyCenter, altGridifyCenter, setGrid, makeGrid, grid, centerPage, gridScale, scaleToCanvas};