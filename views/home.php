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

<script type = "text/javascript" src="../js/chart.js"></script>

<style>
    body{
        background: rgba(0,0,0,0.05);
    }
    .image {
        margin-top: 1.5rem;
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
</style>
