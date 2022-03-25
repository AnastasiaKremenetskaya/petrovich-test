<?php

namespace Database;

use App\Exceptions\InternalServerException;
use Exception;
use PDO;

class DbConnection
{
    /**
     * @var PDO
     */
    private PDO $connection;

    /**
     * @throws InternalServerException
     */
    public function __construct()
    {
        $host = 'db';
        $user = "root";
        $password = env('DB_PASSWORD');
        $dbname = env('DB_DATABASE');
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->connection = new PDO($dsn, $user, $password, $opt);
        } catch (Exception $e) {
            throw new InternalServerException();
        }
    }

    public function get(): PDO
    {
        return $this->connection;
    }
}
