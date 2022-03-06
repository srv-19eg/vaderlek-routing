<?php

namespace App\Models;

use App\Models\Singleton;
use PDO;

/**
 * Bygger på att klassen Singleton sköter själva kopplingen till databasen
 * Denna klass skapar allmänna metoder för att jobba mot databasen
 * Andra klasser ärver denna (abstract)
 */
abstract class Database
{
    public PDO $pdo;

    /**
     *  Hämta upp pdo-objektet från Singleton-klassen
     */
    public function __construct()
    {
        $this->pdo = Singleton::getInstance()->getPDO();
    }

    /**
     * @param string $sql
     * @return bool
     */
    public function query(string $sql)
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    /**
     * @param string $sql
     * @param int|null $fetchMode
     * @return array|bool
     */
    public function fetch(string $sql, int $fetchMode = null): array|bool
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        if ($fetchMode) {
            $results = $stmt->fetch($fetchMode);
        } else {
            $results = $stmt->fetch();
        }
    }

    /**
     * @param string $sql
     * @param int|null $fetchMode
     * @return array|false
     */
    public function fetchAll(string $sql, int $fetchMode = null):array|bool
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        if ($fetchMode) {
            $results = $stmt->fetchAll($fetchMode);
        } else {
            $results = $stmt->fetchAll();
        }
        return $results;
    }

    /**
     * @param string $sql
     * @return mixed
     */
    public function fetchColumn(string $sql): mixed
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }


}