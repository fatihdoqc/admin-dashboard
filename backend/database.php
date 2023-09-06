<?php

//    $host = getenv('MYSQL_HOST');
$host = "127.0.0.1";
//    $dbName = getenv('MYSQL_DB');
$dbName = "dashboardlocal";
//    $user = getenv('MYSQL_USER');
$user = "root";
//    $pass = getenv('MYSQL_PASSWORD');
$pass = "";

try{
    $dsn = "mysql:host=" . $host . ";dbname=" . $dbName;
//    $dsn = $host . '; dbname=' . $dbName;
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//    $userQuery = "INSERT INTO users (name, ramUsage, discUsage) VALUES (:str, 3, 5)";
    $userQuery = "SELECT * FROM users";
    $stmt = $conn->prepare($userQuery);

    $stmt->execute();

    $users = $stmt->fetchAll();

    echo json_encode($users);

}catch (PDOException $exception){
    echo "Database error" . $exception;
}

?>