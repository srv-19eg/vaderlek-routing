<?php

namespace App\Models;

use PDO;
use Carbon\Carbon;

class Weather extends Database
{
    /**
     * @return bool|array
     */
    public function index(): bool|array
    {
        $sql = "select * from weather";
        return $this->fetchAll($sql, PDO::FETCH_ASSOC);
    }

    public function days(int $days = 7)
    {
        $sql = "select max(created_at) from weather";
        $latest = $this->fetchColumn($sql);
        $date = Carbon::create($latest)->addDays(-$days);
        $sql = "select * from weather where created_at > '$date'";
        return $this->fetchAll($sql, PDO::FETCH_ASSOC);
    }


}