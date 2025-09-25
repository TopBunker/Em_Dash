import { Application, Container, Graphics, Sprite, DisplacementFilter, Assets, FillGradient, Text, TextStyle, BitmapText } from "pixi.js";


class PixiManager {
    constructor(canvas) {
        this.application = new Application();
        this.dom = canvas;
        this.appInit();
    }

    async appInit() {
        await this.application.init({
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
        });
        this.dom.appendChild(this.application.canvas);
    }

    addChild(child) {
        this.application.stage.addChild(child);
    }

    removeChild(child) {
        this.application.stage.removeChild(child);
    }

    addTicker(fn) {
        this.application.ticker.add(fn);
    }

    removeTicker(fn) {
        this.application.ticker.remove(fn);
    }

    getApp() {
        return this.application;
    }

    render() {
        this.application.renderer.render(this.application.stage);
    }
}

export default PixiManager;