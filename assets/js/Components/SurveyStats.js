import 'chart.js';
const $ = require("jquery");

const SELECTOR = '#chart-stats-canvas';

class SurveyStats
{
    constructor() {
        this.surveyStatsArea = $(SELECTOR);
        if(this.surveyStatsArea.length) {
            this._initChart();
        }
    }

    _initChart() {
        var redColor = 'rgb(255, 99, 132)';
        var color = Chart.helpers.color;
        var horizontalBarChartData = {
            labels: this.surveyStatsArea.data('labels'),
            datasets: [{
                label: 'Answers',
                backgroundColor: color(redColor).alpha(0.5).rgbString(),
                borderColor: redColor,
                borderWidth: 1,
                data: this.surveyStatsArea.data('sets')
            }]

        };

        var ctx = $('#chart-stats-canvas')[0].getContext('2d');
        var myHorizontalBar = new Chart(ctx, {
            type: 'horizontalBar',
            data: horizontalBarChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                scales: {
                    xAxes: [{
                        ticks: {
                            beginAtZero: true,
                            suggestedMax: 5
                        }
                    }]
                }
            }
        });
    }
}

export default SurveyStats;