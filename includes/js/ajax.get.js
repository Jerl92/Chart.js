
function get_chart_data($) {
    
    $.fn.ready();
	'use strict';

    var $this = $(this);
    nonce = $this.data('nonce');
        object_id = $("#canvas").attr('data-chartid');

    $.ajax({
        type: 'post',
        url: get_ajax_url,
        dataType: 'JSON',
        data: {
            'object_id': object_id,
            'action': 'get_chart'
        },
        success: function(data) {
            console.log(data);
            var MONTHS = data[0];
            var color = Chart.helpers.color;

            var barChartData = {
                labels: MONTHS,
                datasets: []        
            };        

            var ctx = document.getElementById('canvas').getContext('2d');

            if (ctx) {
                data[3].forEach(function (element, index) {
                    barChartData.datasets.push({
                        label: data[1][index],
                        borderColor: '#'+data[2][index],
                        borderWidth: 1,
                        data: element
                    });
                });

                
                window.myBar = new Chart(ctx, {
                    type: $("#canvas").attr('data-chart-type'),
                    data: barChartData,
                    options: {
                        responsive: true,
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: false
                        }
                    }
                });
            }

        },
        error: function(error) {
            console.log(error);
        }
    });
}

function get_chart_data_widget($) {
    
    $.fn.ready();
	'use strict';

    var $this = $(this);
    nonce = $this.data('nonce');
        object_id = $("#canvas-widget").attr('data-chartid');

    $.ajax({
        type: 'post',
        url: get_ajax_url,
        dataType: 'JSON',
        data: {
            'object_id': object_id,
            'action': 'get_chart'
        },
        success: function(data) {
            console.log(data);
            var MONTHS = data[0];
            var color = Chart.helpers.color;

            var barChartData = {
                labels: MONTHS,
                datasets: []        
            };        

            
            var ctx = document.getElementById('canvas-widget').getContext('2d');

            if (ctx) {
                data[3].forEach(function (element, index) {
                    barChartData.datasets.push({
                        label: data[1][index],
                        borderColor: '#'+data[2][index],
                        borderWidth: 1,
                        data: element
                    });
                });

                window.myBar = new Chart(ctx, {
                    type: $("#canvas-widget").attr('data-chart-type'),
                    data: barChartData,
                    options: {
                        responsive: true,
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: false
                        }
                    }
                });
            }

        },
        error: function(error) {
            console.log(error);
        }
    });
}

jQuery(document).ready(function($) {
    get_chart_data($);
    get_chart_data_widget($);
});
