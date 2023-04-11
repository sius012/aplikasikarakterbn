import Bootstrap from './bootstrap';
import Chart from 'chart.js/auto';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import jQuery from 'jquery';
import DataTable from 'datatables.net-dt';
import "datatables.net-bs4";
import jszip from 'jszip';
import pdfmake from 'pdfmake';
import DataTable from 'datatables.net-dt';
import 'datatables.net-buttons-dt';
import 'datatables.net-buttons/js/buttons.colVis.mjs';
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';


window.Alpine = Alpine;
window.Chart = Chart;
window.Swal = Swal;


window.$ = window.jQuery = require('jquery');




Alpine.start();