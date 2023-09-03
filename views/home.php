<?php

    $host = getenv('MYSQL_HOST');
    $dbName = getenv('MYSQL_DB');
    $user = getenv('MYSQL_USER');
    $pass = getenv('MYSQL_PASSWORD');

    try{
        $connection = new PDO($host . '; dbname='. $dbName, $user, $pass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "DB CASLti! ";

        $userQuery = "INSERT INTO denemeTable (denemeCol) VALUES (:str)";

        $stmt = $connection->prepare($userQuery);

        $stmt->execute(['str' => 'BOOM']);

        echo " Yazdim.";

    }catch (PDOException $exception){
        echo "Database error" . $exception;
    }

?>