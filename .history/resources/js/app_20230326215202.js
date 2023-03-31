import Bootstrap from './bootstrap';
import Chart from 'chart.js/auto';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.Chart = Chart;

window.$ = window.jQuery = require('jquery');




Alpine.start();