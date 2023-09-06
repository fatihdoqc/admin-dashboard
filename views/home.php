<!DOCTYPE html>
<html>
<body>
<?php
include 'header.php';
?>

<div class="ui two column grid" style="margin-top: 2px; margin-left: 4%">
    <div class="row">
        <div class="column">
            <div class="ui card large" style="width: 98%;">
                <div class="content">
                    <a class="header">RAM Usage (Out of 50GB) </a>
                    <div class="description">
                        <div id="pie-chart" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="ui card large" style="width: 90%; ">
                <div class="content">
                    <a class="header">Disc Usage (GB)</a>
                    <div class="description">
                        <div id="bar-chart" style="width:100%; height:400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.ui.dropdown').dropdown();
</script>

</body>
</html>

<!--<script type = "text/javascript" src="../static/js/chartAndDatatable.js"></script>-->
<?php


$host = getenv('MYSQL_HOST');
//$host = "127.0.0.1";
$dbName = getenv('MYSQL_DB');
//$dbName = "dashboardlocal";
$user = getenv('MYSQL_USER');
//$user = "root";
$pass = getenv('MYSQL_PASSWORD');
//$pass = "";

try{
    //$dsn = "mysql:host=" . $host . ";dbname=" . $dbName;
    $dsn = $host . '; dbname=' . $dbName;
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//    $userQuery = "INSERT INTO users (name, ramUsage, discUsage) VALUES (:str, 3, 5)";
    $userQuery = "SELECT * FROM users";
    $stmt = $conn->prepare($userQuery);

//    $stmt->execute(['str' => 'fdog']);
    $stmt->execute();

    $users = $stmt->fetchAll();

    header('Content-Type: application/json; charset=utf-8');

}catch (PDOException $exception){
    echo "Database error" . $exception;
}

?>
<script>
    let userDatas = [];
    let ramUsages = [];
    let discUsages = [];
    let users =  [];
    let totalRam = 0;

    userDatas = <?php echo json_encode($users); ?>;
    userDatas.forEach(temp => {
        ramUsages.push( {name: temp.name, y: temp.ramUsage });
        totalRam += temp.ramUsage;
        discUsages.push(temp.discUsage);
        users.push(temp.name);
    });

    ramUsages.push( {name: 'Free', y: 50 - totalRam, color: '#4c4f52'});

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
                '<td style="padding:0"><b>{point.y:.1f} GB</b></td></tr>',
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
</script>

<style>
    body{
        background: rgba(0,0,0,0.05);
    }
</style>
