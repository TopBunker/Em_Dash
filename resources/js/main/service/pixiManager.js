import { Application, Container, Graphics, Sprite, DisplacementFilter, Assets, FillGradient, Text, TextStyle, BitmapText } from "pixi.js";


class PixiManager {
    static instance = null;

    constructor(canvas) {
        if (PixiManager.instance) return PixiManager.instance;
        this.app = new Application();
        this.ready = this._init();
        this.dom = canvas;
        PixiManager.instance = this;
    }

    async _init() {
        await this.app.init({
            backgroundAlpha: 0, 
            powerPreference: 'high-performance',
            width: window.innerWidth,
            height: window.innerHeight,
            autoDensity: true,
            antialias: false,
            resolution: window.devicePixelRatio,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: "high",
            resizeTo: window
        });

        if (!this.app.canvas.parentElement) {
            this.dom.appendChild(this.app.canvas);
        }
        if (!this.app.ticker.started) {
            this.app.ticker.start();
        }
        return this.app;
    }

    async addChild(child) {
        const app = await this.ready;
        app.stage.addChild(child);
    }

    async addChildAt(child, position) {
        const app = await this.ready;
        if(app.stage.children.length <= (position + 1)){
            app.stage.addChildAt(child, position);
        }else {
            console.error('Position out of range.');
            return 'Out of range.';
        }
    }

    async removeChild(child) {
        const app = await this.ready;
        app.stage.removeChild(child);
    }

    async addTicker(fn) {
        const app = await this.ready;
        app.ticker.add(fn);
    }

    async addOnce(fn, context) {
        const app = await this.ready;
        app.ticker.addOnce(fn, context);
    }

    async removeTicker(fn) {
        const app = await this.ready;
        app.ticker.remove(fn);
    }

    async render() {
        const app = await this.ready;
        app.renderer.render(app.stage);
    }

    destroy() {
        if (this.app) {
            this.app.destroy(true, {children: true});
            this.app = null;
            PixiManager.instance = null;
        }
    }
}

export default PixiManager;