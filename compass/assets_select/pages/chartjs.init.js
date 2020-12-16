/*
 Template Name: Agroxa - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesbrand
 File: Chart js
 */
var start = document.getElementById('start').value,
    finish = document.getElementById('finish').value;
var dates = {
    startD:start,
    finishD:finish
};
dates = JSON.stringify(dates);
$.ajax({
    url: "select_ajax_stastics.php",
    method: "POST",
    data: {values: dates},
    success: function (data){
        //alert(data);
        var values = JSON.parse(data);
        if(values.done_price==null){
            values.done_price=0;
        }
        if(values.income_price==null){
            values.income_price=0;
        }
        //var summa_price=Number(values.summa_price);
            document.getElementById('tick_act').textContent=(values.plan_price);
            document.getElementById('tick_dis_act').textContent=(values.done_price);
            document.getElementById('tick_total_act').textContent=(values.income_price);
            document.getElementById('dept_num').textContent=(values.dept_summa);
        //drivers
        //var dr_active = Number(values.dr_active);
        document.getElementById('dr_act').textContent=values.active_dr;
        document.getElementById('dr_dis_act').textContent=values.no_active_dr;
        document.getElementById('dr_total_act').textContent=Number(values.total_dr);
        //alert(data);
        !function ($) {
            "use strict";

            var ChartJs = function () {
            };

            ChartJs.prototype.respChart = function (selector, type, data, options) {
                // get selector by context
                var ctx = selector.get(0).getContext("2d");
                // pointing parent container to make chart js inherit its width
                var container = $(selector).parent();

                // enable resizing matter
                $(window).resize(generateChart);

                // this function produce the responsive Chart JS
                function generateChart() {
                    // make chart width fit with its container
                    var ww = selector.attr('width', $(container).width());
                    switch (type) {
                        case 'Line':
                            new Chart(ctx, {type: 'line', data: data, options: options});
                            break;
                        case 'Doughnut':
                            new Chart(ctx, {type: 'doughnut', data: data, options: options});
                            break;
                        case 'Pie':
                            new Chart(ctx, {type: 'pie', data: data, options: options});
                            break;
                        case 'Bar':
                            new Chart(ctx, {type: 'bar', data: data, options: options});
                            break;
                        case 'Radar':
                            new Chart(ctx, {type: 'radar', data: data, options: options});
                            break;
                        case 'PolarArea':
                            new Chart(ctx, {data: data, type: 'polarArea', options: options});
                            break;
                    }
                    // Initiate new chart or Redraw

                };
                // run function - render chart at first load
                generateChart();
            },
                //init
                ChartJs.prototype.init = function () {
                    //creating lineChart
                    var lineChart = {
                        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October"],
                        datasets: [
                            {
                                label: "Sales Analytics",
                                fill: true,
                                lineTension: 0.5,
                                backgroundColor: "rgba(245, 178, 37, 0.2)",
                                borderColor: "#f5b225",
                                borderCapStyle: 'butt',
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: 'miter',
                                pointBorderColor: "#f5b225",
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "#f5b225",
                                pointHoverBorderColor: "#fff",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 10,
                                data: [65, 59, 80, 81, 56, 55, 40, 55, 30, 80]
                            },
                            {
                                label: "Monthly Earnings",
                                fill: true,
                                lineTension: 0.5,
                                backgroundColor: "rgba(235, 239, 242, 0.2)",
                                borderColor: "#ebeff2",
                                borderCapStyle: 'butt',
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: 'miter',
                                pointBorderColor: "#ebeff2",
                                pointBackgroundColor: "#fff",
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: "#ebeff2",
                                pointHoverBorderColor: "#eef0f2",
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 10,
                                data: [80, 23, 56, 65, 23, 35, 85, 25, 92, 36]
                            }
                        ]
                    };

                    var lineOpts = {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    max: 100,
                                    min: 20,
                                    stepSize: 10
                                }
                            }]
                        }
                    };

                    this.respChart($("#lineChart"), 'Line', lineChart, lineOpts);
                    //donut chart
                    var donutChart = {
                        labels: [
                            "Plastik",
                            "Naqd",
                            "Click",
                            "Skidka"
                        ],
                        datasets: [
                            {
                                data: [values.plastik, values.naqd,values.click,values.skidka],
                                backgroundColor: [
                                    "#f5b225",
                                    "#ebeff2",
                                    "#245abd",
                                    "#fedecd"
                                ],
                                hoverBackgroundColor: [
                                    "#f5b225",
                                    "#ebeff2",
                                    "#245abd",
                                    "#fedecd"
                                ],
                                hoverBorderColor: "#fff"
                            }]
                    };
                    this.respChart($("#doughnut"), 'Doughnut', donutChart);


                    //Pie chart
                    var pieChart = {
                        labels: [
                            "Kelganlar",
                            "Kelmaganlar"
                        ],
                        datasets: [
                            {
                                data: [values.come_dr, values.no_come_dr],
                                backgroundColor: [
                                    "#1b82ec",
                                    "#ebeff2"
                                ],
                                hoverBackgroundColor: [
                                    "#1b82ec",
                                    "#ebeff2"
                                ],
                                hoverBorderColor: "#fff"
                            }]
                    };
                    this.respChart($("#pie"), 'Pie', pieChart);

                    //barchart
                    var barChart = {
                        labels: ["January", "February", "March", "April", "May", "June", "July"],
                        datasets: [
                            {
                                label: "Sales Analytics",
                                backgroundColor: "#1b82ec",
                                borderColor: "#1b82ec",
                                borderWidth: 1,
                                hoverBackgroundColor: "#1b82ec",
                                hoverBorderColor: "#1b82ec",
                                data: [65, 59, 81, 45, 56, 80, 50, 20]
                            }
                        ]
                    };
                    this.respChart($("#bar"), 'Bar', barChart);


                    //radar chart
                    var radarChart = {
                        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
                        datasets: [
                            {
                                label: "Desktops",
                                backgroundColor: "rgba(245, 178, 37, 0.2)",
                                borderColor: "#f5b225",
                                pointBackgroundColor: "#f5b225",
                                pointBorderColor: "#fff",
                                pointHoverBackgroundColor: "#fff",
                                pointHoverBorderColor: "#f5b225",
                                data: [65, 59, 90, 81, 56, 55, 40]
                            },
                            {
                                label: "Tablets",
                                backgroundColor: "rgba(27, 130, 236, 0.2)",
                                borderColor: "#1b82ec",
                                pointBackgroundColor: "#1b82ec",
                                pointBorderColor: "#fff",
                                pointHoverBackgroundColor: "#fff",
                                pointHoverBorderColor: "#1b82ec",
                                data: [28, 48, 40, 19, 96, 27, 100]
                            }
                        ]
                    };
                    this.respChart($("#radar"), 'Radar', radarChart);

                    //Polar area  chart
                    var polarChart = {
                        datasets: [{
                            data: [
                                11,
                                16,
                                7,
                                18
                            ],
                            backgroundColor: [
                                "#f16c69",
                                "#1b82ec",
                                "#ebeff2",
                                "#f5b225"
                            ],
                            label: 'My dataset', // for legend
                            hoverBorderColor: "#fff"
                        }],
                        labels: [
                            "Series 1",
                            "Series 2",
                            "Series 3",
                            "Series 4"
                        ]
                    };
                    this.respChart($("#polarArea"), 'PolarArea', polarChart);
                },
                $.ChartJs = new ChartJs, $.ChartJs.Constructor = ChartJs

        }(window.jQuery),

//initializing
            function ($) {
                "use strict";
                $.ChartJs.init()
            }(window.jQuery);
    }
})