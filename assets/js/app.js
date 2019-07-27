/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.scss in this case)
import '../css/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
import $ from 'jquery';

window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker';
import * as Highcharts from 'highcharts';

$('document').ready(function () {
    $('#company_fromDate, #company_toDate').datepicker({
        dateFormat: 'dd-mm-yy',
    });

    const dateOpen  = $('#chart').data('chart-open');
    const dateClose = $('#chart').data('chart-close');

    if ($('#chart').length === 0) {
        return;
    }

    Highcharts.chart('chart', {

        title: false,

        legend: {
            layout       : 'vertical',
            align        : 'right',
            verticalAlign: 'middle',
        },

        plotOptions: {
            series: {
                label     : {
                    connectorAllowed: false,
                },
            },
        },

        series: [
            {
                name: 'Open Price',
                data: dateOpen,
            }, {
                name: 'Close Price',
                data: dateClose,
            },
        ],

        xAxis: {
            type: 'datetime',
            labels: {
                format: '{value:%Y-%m-%d}'
            },
        },

        responsive: {
            rules: [
                {
                    condition   : {
                        maxWidth: 500,
                    },
                    chartOptions: {
                        legend: {
                            layout       : 'horizontal',
                            align        : 'center',
                            verticalAlign: 'bottom',
                        },
                    },
                },
            ],
        },

    });
});

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
