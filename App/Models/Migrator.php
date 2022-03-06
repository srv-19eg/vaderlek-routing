<?php

namespace App\Models;

class Migrator extends Database
{
    public function dropTable(string $table)
    {
        $sql = "drop table if exists $table";
        return $this->query($sql);
    }

    public function createWeatherTable()
    {
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
            );
        EOD;
        return $this->query($sql);
    }

    public function populateFromFile(string $filename)
    {
        if (($handle = fopen($filename, "r")) !== FALSE) {
            $isFirstRow = true;
            $insertedRows = 0;
            $sql = "insert into weather values";
            while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                if ($isFirstRow) {
                    $isFirstRow = false;
                    continue;
                }
                $sql .= "(
                $data[0],
                '$data[1]',
                $data[2],
                $data[3],
                $data[4],
                $data[5],
                $data[6],
                $data[7],
                $data[8],
                $data[9],
                $data[10],
                '$data[11]',
                $data[12],
                $data[13],
                $data[14],
                $data[15],
                $data[16],
                $data[17],
                $data[18]
                ),";
                $insertedRows++;
            }
            fclose($handle);
            $sql = rtrim($sql,",");
            $this->query($sql);
        }
    }
}