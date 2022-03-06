<?php
namespace App\Controllers;
use App\Models\Weather;

class ApiController
{
    public function index()
    {
        $weather = new Weather();
        $data = $weather->index();
        outputJson($data);
    }

    public function latestDays(int $days = 7)
    {
        $weather = new Weather();
        $data = $weather->days($days);
        outputJson($data);
    }

}