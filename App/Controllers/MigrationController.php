<?php
namespace App\Controllers;
use App\Models\Migrator;
use Pecee\SimpleRouter\SimpleRouter;

class MigrationController
{
    /**
     * Migrera tabellen weather utifrån en indatafil
     * @return void
     */
    public function migrate()
    {
        $migrator = new Migrator();
        $migrator->dropTable('weather');
        $migrator->createWeatherTable();
        $migrator->populateFromFile('C:\code\vaderlek-routing\App\Models\weather_data_a.csv');
        SimpleRouter::response()->redirect('/');
    }
}