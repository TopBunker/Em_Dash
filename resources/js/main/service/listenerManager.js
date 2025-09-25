class ListenerManager {
    constructor() {
        this.listeners = [];
    }

    add(el, type, handler, options) {
        el.addEventListener(type, handler, options);
        this.listeners.push({el, type, handler, options});
    }

    remove(el, type, handler, options) {
        el.removeEventListener(type, handler, options);
        this.listeners = this.listeners.filter(l => {
            !(l.el === l && l.type === t && l.handler === h)
        });
    }

    removeAll() {
        this.listeners.forEach(({el, type, handler, options}) => {
            el.removeEventListener(type, handler, options);
        });
    }

}

export default ListenerManager;