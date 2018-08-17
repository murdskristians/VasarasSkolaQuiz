<?php


namespace Quiz\Repositories;

use PDO;
use Quiz\Interfaces\RepositoryInterface;

abstract class BaseDatabaseRepository implements RepositoryInterface
{
    protected $connection;

    public function getConnection()
    {
        //return $this->config->driver . ':hosts=' . $this->config->host . ';charset=utf8;dbname= ' . $this->config->database;
        $name = "mysql:host=127.0.0.1;charset=utf8;dbname=homestead";
        $this->connection = new PDO($name, 'homestead', 'secret');
    }

    public function getById(int $id)
    {
        $this->getConnection();
        $table = static::getTableName();
        $sql = "SELECT * FROM $table WHERE id = ?";
        $statement = $this->connection->prepare($sql);

        //Execute parametri pēc kārtas aizstāj jautājumzīmes sql mainīgajā
        $statement->execute([$id]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


}