let userDatas = [];
let ramUsages = [];
let discUsages = [];
let users =  [];
let totalRam = 0;
let dataSet = [];
$.ajax({
    url: '../backend/database.php',
    success: function(data) {
        userDatas = data;
        userDatas = JSON.parse(userDatas);

        userDatas.forEach(temp => {
            dataSet.push( [temp.name, temp.ramUsage, temp.discUsage] );
            ramUsages.push( {name: temp.name, y: temp.ramUsage });
            totalRam += temp.ramUsage;
            discUsages.push(temp.discUsage);
            users.push(temp.name);
        });

        ramUsages.push( {name: 'Free', y: 50 - totalRam, color: '#4c4f52'});

        new DataTable('#myTable', {
            columns: [
                { title: 'Name' },
                { title: 'Ram Usage (GB)' },
                { title: 'Disc Usage (GB)' },
            ],
            data: dataSet
        });

        Highcharts.chart('pie-chart', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '',
                align: 'left'
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Ram Usage (GB)',
                colorByPoint: true,
                data: ramUsages,
            }]
        });

        Highcharts.chart('bar-chart', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: users,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Disc Usage (GB)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Disc Usage (GB)',
                data: discUsages,
                color: '#ac0013',

            }]
        });

    }
});

