<?php

namespace App\Database;

use App\Business\Utils\Database\DBConnection;
use App\Business\Utils\Exceptions\ErrorOnConnectToDatabaseException;
use Exception;
use PDO;
use PDOException;

class PdoConnection implements DBConnection
{
    private PDO $connection;

    private string $driver;
    private string $host;
    private string $port;
    private string $dbName;
    private string $userName;
    private string $password;

    /**
     * @throws ErrorOnConnectToDatabaseException
     */
    public function __construct()
    {
        try {

            $this->initializeEnvironmentVariables();

            $dsn = $this->driver . ':host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbName;
            $this->connection = new PDO(
                dsn: $dsn,
                username: $this->userName,
                password: $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException|Exception $exception) {
            throw new ErrorOnConnectToDatabaseException($exception->getMessage());
        }
    }

    /**
     * @return void
     */
    private function initializeEnvironmentVariables(): void
    {
        $this->driver = getenv('DB_CONNECTION');
        $this->host = getenv('DB_HOST');
        $this->port = getenv('DB_PORT');
        $this->dbName = getenv('DB_DATABASE');
        $this->userName = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}