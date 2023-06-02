let categories = [];
var chartA = new Highcharts.chart('LineA', {
    chart: {
        zoomType: 'x',
        resetZoomButton: {
            position: {
              verticalAlign: 'bottom',
              x: 0,
              y: 100
            }
        },
    },
    title: {
        text: 'Chart RO Line A',
        align: 'center'
    },
    subtitle: {
        text: document.ontouchstart === undefined ?
        'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in',
        align: 'center'
    },
    xAxis: [{
        type: 'categories'
    }, {
        type: 'categories'
    }],
    yAxis: {
        title: {
            text: 'RO Value'
        },
        plotLines: [{
            color: 'red',
            dashStyle: 'longashdot',
            value: 2,
            width: 2,
            label:  {
                text: 'Max',
                align: 'left',
                y: 2,
            }

        }, {
            color: 'yellow',
            dashStyle: 'longashdot',
            value: 1.8,
            width: 2,
            label:  {
                text: 'Safety',
                align: 'left',
                y: 5
            }
        }],
    },
    legend: {
        enabled: true
    },
    plotOptions: {
        area: {
            fillColor: {
                linearGradient: {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                stops: [
                    [0, Highcharts.getOptions().colors[0]],
                    [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                ]
            },
        },
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        },
        series: {
            turboThreshold:3000,
            cursor: 'pointer',
            point: {
                events: {
                    click: function() {
                        if (this.y > 2) {
                            reasonModal(this.series.name, this.category, this.y);
                        }
                    }
                }
            }
        },
    },
    exporting: {
        csv: {
            dateFormat: '%Y'
        }
    },
    tooltip: {
        useHTML: true,
        formatter: function() {
            return 'RO :<span class="ro-value">'+this.y +'</span>'+
                '<br>Waktu :<span class="time-value">'+this.x +'</span>'+
                '<br>Line Process :<span class="line-value">'+this.series.name +'</span>';
        },
        style: {
          pointerEvents: 'all'
        }
    },            
    series: [{
        type: "area",
        name: 'Filling Sachet A1',
        data: []
    }, {
        type: "area",
        name: 'Filling Sachet A2',
        data: []
    }]
});

var chartE = new Highcharts.chart('LineE', {
    chart: {
        zoomType: 'x',
        resetZoomButton: {
            position: {
              verticalAlign: 'bottom',
              x: 0,
              y: 100
            }
        },
    },
    title: {
        text: 'Chart RO Line E',
        align: 'center'
    },
    subtitle: {
        text: document.ontouchstart === undefined ?
        'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in',
        align: 'center'
    },
    xAxis: [{
        type: 'categories'
    }, {
        type: 'categories'
    }],
    yAxis: {
        title: {
            text: 'RO Value'
        },
        plotLines: [{
            color: 'red',
            dashStyle: 'longashdot',
            value: 2,
            width: 2,
            label:  {
                text: 'Max',
                align: 'left',
                y: 2,
            }

        }, {
            color: 'yellow',
            dashStyle: 'longashdot',
            value: 1.8,
            width: 2,
            label:  {
                text: 'Safety',
                align: 'left',
                y: 5
            }
        }],
    },
    legend: {
        enabled: true
    },
    plotOptions: {
        area: {
            fillColor: {
                linearGradient: {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                stops: [
                    [0, Highcharts.getOptions().colors[0]],
                    [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                ]
            },
        },
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        },
        series: {
            turboThreshold:3000,
            cursor: 'pointer',
            point: {
                events: {
                    click: function() {
                        if (this.y > 2) {
                            reasonModal(this.series.name, this.category, this.y);
                        }
                    }
                }
            }
        },
    },
    exporting: {
        csv: {
            dateFormat: '%Y'
        }
    },    
    tooltip: {
        useHTML: true,
        formatter: function() {
            return 'RO :'+this.y +
                '<br>Waktu :'+this.x +
                '<br>Line Process :'+this.series.name;
        },
        style: {
          pointerEvents: 'auto'
        }
    },        
    series: [{
        type: "area",
        name: 'Filling Sachet E1',
        data: []
    }, {
        type: "area",
        name: 'Filling Sachet E2',
        data: []
    }]
});

var chartJ = new Highcharts.chart('LineJ', {
    chart: {
        zoomType: 'x',
        resetZoomButton: {
            position: {
              verticalAlign: 'bottom',
              x: 0,
              y: 100
            }
        },
    },
    title: {
        text: 'Chart RO Line J',
        align: 'center'
    },
    subtitle: {
        text: document.ontouchstart === undefined ?
        'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in',
        align: 'center'
    },
    xAxis: [{
        type: 'categories'
    }, {
        type: 'categories'
    }],
    yAxis: {
        title: {
            text: 'RO Value'
        },
        plotLines: [{
            color: 'red',
            dashStyle: 'longashdot',
            value: 2,
            width: 2,
            label:  {
                text: 'Max',
                align: 'left',
                y: 2,
            }

        }, {
            color: 'yellow',
            dashStyle: 'longashdot',
            value: 1.8,
            width: 2,
            label:  {
                text: 'Safety',
                align: 'left',
                y: 5
            }
        }],
    },
    legend: {
        enabled: true
    },
    plotOptions: {
        area: {
            fillColor: {
                linearGradient: {
                    x1: 0,
                    y1: 0,
                    x2: 0,
                    y2: 1
                },
                stops: [
                    [0, Highcharts.getOptions().colors[0]],
                    [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                ]
            },
        },
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        },
        series: {
            turboThreshold:3000,
            cursor: 'pointer',
            point: {
                events: {
                    click: function() {
                        if (this.y > 2) {
                            reasonModal(this.series.name, this.category, this.y);
                        }
                    }
                }
            }
        },
    },
    exporting: {
        csv: {
            dateFormat: '%Y'
        }
    },
    tooltip: {
        useHTML: true,
        formatter: function() {
            return 'RO :'+this.y +
                '<br>Waktu :'+this.x +
                '<br>Line Process :'+this.series.name;
        },
        style: {
          pointerEvents: 'auto'
        }
    },             
    series: [{
        type: "area",
        name: 'Filling Sachet J1',
        data: []
    }, {
        type: "area",
        name: 'Filling Sachet J2',
        data: []
    }]
});