import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import $ from 'jquery';
window.$ = window.jQuery = $;

import {Assets} from 'pixi.js';

Assets.backgroundLoad(['/storage/images/system/waves/crumpled-fabric-wave.jpg']);