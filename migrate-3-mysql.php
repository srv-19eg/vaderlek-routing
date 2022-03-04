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
// OBS
// Det krävs att lägga till inställningen att tillåta MYSQL att läsa lokala filer!
// Annars är inte MySQL tillåtet att göra det helt enkelt!
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass, [PDO::MYSQL_ATTR_LOCAL_INFILE => true]);
// OBS Det krävs att lägga till inställningen att tillåta MYSQL att läsa lokala filer!
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

// inserting
$filename ="weather_data_a.csv";
$path = dirname(__FILE__).DIRECTORY_SEPARATOR.$filename;
$sql = <<<EOD
LOAD DATA LOCAL INFILE 'weather_data_a.csv'
    IGNORE
    INTO TABLE weather
    FIELDS TERMINATED BY ';'
    LINES TERMINATED BY '\n'
    IGNORE 1 LINES;
EOD;
$pdo->query($sql);

$endTime = microtime(true);
echo "Ending script. Time: $endTime<br>";

echo "Total time in s: ". $endTime-$startTime;