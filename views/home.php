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
        echo $user;
        $dsn = "mysql:host=" . $host . ";dbname=" . $dbName;
        $conn = new PDO($dsn, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "DB CASLti! ";

        $userQuery = "INSERT INTO users (email) VALUES (:str)";

        $stmt = $conn->prepare($userQuery);

        $stmt->execute(['str' => 'BOOM']);

        echo " Yazdim.";

    }catch (PDOException $exception){
        echo "Database error" . $exception;
    }

?>