<?php
//läs in filen till
//https://www.php.net/manual/en/function.fgetcsv.php

$startTime = microtime(true);
echo "Starting script. Time: $startTime<br>";

// connect to db
echo "Connecting to db<br>";
$host = "localhost";
$db = "weather_db";
$user = "root";
$pass = "";
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


// migrating
echo "Dropping table<br>";
$sql = "drop table if exists weather";
$pdo->query($sql);

echo "Creating table<br>";
$sql = <<<EOD
    create table weather(
        id int primary key,
    created_at timestamp,
    interval_time int,
    temp_indoor float,
    humidity_indoor float,
    temp_outdoor float,
    humidity_outdoor float,
    air_pressure_rel float,
    air_pressure_abs float,
    wind_speed float,
    wind_squall float,
    wind_direction varchar(5),
    dewpoint float,
    wind_cooling float,
    rain_amount_h float,
    rain_amount_24h float,
    rain_amount_week float,
    rain_amount_month float,
    rain_amount_total float
)
EOD;
$pdo->query($sql);


if (($handle = fopen("weather_data_a.csv", "r")) !== FALSE) {
    $isFirstRow = true;
    $insertedRows = 0;
    $sql = "insert into weather values";
    while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
        if ($isFirstRow) {
            $isFirstRow = false;
            continue;
        }
        $sql .= "($data[0],'$data[1]',$data[2],$data[3],$data[4],$data[5],$data[6],$data[7],$data[8],$data[9],$data[10],'$data[11]',$data[12],$data[13],$data[14],$data[15],$data[16],$data[17],$data[18]),";
        $insertedRows++;
    }
    fclose($handle);
    $sql = rtrim($sql,",");
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    unset($stmt);
    unset($pdo);

}
$endTime = microtime(true);
echo "Ending script. Time: $endTime<br>";
echo "Total time in s: ". $endTime-$startTime;
