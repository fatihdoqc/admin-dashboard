<!DOCTYPE html>
<html>
<body>
<?php
include 'header.php';
?>

<div class="ui two column grid" style="margin-top: 2px; margin-left: 2px">
    <div class="row">
        <div class="column">
            <div class="ui card large" style="width: 100%">
                <div class="content">
                    <a class="header">Orders</a>
                    <div class="description">
                        Kristy is an art director living in New York.aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                    </div>
                </div>
            </div>
        </div>
        <div class="column">b</div>
        <div class="column">c</div>
        <div class="column">d</div>
    </div>
</div>




<script>
    $('.ui.dropdown').dropdown();
</script>
</body>
</html>

<?php

    //$host = getenv('MYSQL_HOST');
    $host = "127.0.0.1";
    //$dbName = getenv('MYSQL_DB');
    $dbName = "dashboardlocal";
//    $user = getenv('MYSQL_USER');
    $user = "root";
//    $pass = getenv('MYSQL_PASSWORD');
    $pass = "";

    try{
        $dsn = "mysql:host=" . $host . ";dbname=" . $dbName;
        $conn = new PDO($dsn, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $userQuery = "INSERT INTO users (email) VALUES (:str)";

        $stmt = $conn->prepare($userQuery);

        $stmt->execute(['str' => 'BOOM']);

    }catch (PDOException $exception){
        echo "Database error" . $exception;
    }

?>