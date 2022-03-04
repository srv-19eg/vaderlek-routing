<?php
namespace App\Controllers;
use App\Models\Weather;

class ApiController
{
    public function index()
    {
        $weather = new Weather();
        return "index";
    }

    public function latestDays(int $days)
    {
        return $days;
    }

    public function latestWeeks(int $weeks=1)
    {
        return $weeks;
    }
}