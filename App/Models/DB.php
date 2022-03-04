<?php
namespace App\Models;
use PDO;

abstract class DB
{
    public PDO $pdo;

    /**
     *
     */
    public function __construct()
    {
        $host = "localhost";
        $db = "weather_db";
        $user = "root";
        $pass = "";
        $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    /**
     * @param string $sql
     * @return void
     */
    public function query(string $sql)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    /**
     * @param string $sql
     * @return mixed
     */
    public function fetch(string $sql)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * @param string $sql
     * @return array|false
     */
    public function fetchAll(string $sql)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * @param string $sql
     * @return mixed
     */
    public function fetchColumn(string $sql)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


}