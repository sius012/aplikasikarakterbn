import Bootstrap from './bootstrap';
import Chart from 'chart.js/auto';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import jQuery from 'jquery';
import DataTables from 'datatables.net-bs4';
require( 'datatables.net-buttons-dt' );
require( 'datatables.net-buttons/js/buttons.colVis.js' );
require( 'datatables.net-buttons/js/buttons.print.js' );

window.Alpine = Alpine;
window.Chart = Chart;
window.Swal = Swal;
window.jQuery = jQuery;

window.$ = window.jQuery = require('jquery');




Alpine.start();