import Bootstrap from './bootstrap';
import Chart from 'chart.js/auto';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import DataTable from 'datatables.net-dt';
import "datatables.net-bs4";


window.Alpine = Alpine;
window.Chart = Chart;
window.Swal = Swal;
var $       = require( 'jquery' );
var dt      = require( 'datatables.net-dt' );
var buttons = require( 'datatables.net-buttons-dt' );

window.$ = window.jQuery = require('jquery');




Alpine.start();