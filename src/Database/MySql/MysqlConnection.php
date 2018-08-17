<?php

namespace Quiz\Database\MySql;

use PDO;
use Quiz\Database\ConnectionFactory;
use Quiz\Interfaces\ConnectionInterface;

class MysqlConnection implements ConnectionInterface
{
    /** @var MysqlConnectionConfig */
    protected $config;

    /** @var PDO */
    protected $connection;

    public function __construct(MysqlConnectionConfig $config = null)
    {
        if (!$config) {
            $config = new MysqlConnectionConfig();
        }
        $this->config = $config;
        $this->connect();
    }

    public function connect()
    {
        $dsn = $this->getDataSourceName();
        $this->connection = new PDO($dsn, $this->config->user, $this->config->password);
    }

    private function getDataSourceName(): string
    {
        return $this->config->driver . ':hosts=' . $this->config->host . ';charset=utf8;dbname= ' . $this->config->database;
    }

    /**
     * @param string $table
     * @param array $conditions
     * @param array $select
     * @return array
     */
    public function select(string $table, array $conditions = [], array $select = []): array
    {
        $conditionsSql = '';
        if ($conditions) {
            $connectionStatements = [];
            $conditionsSql = 'WHERE';
            foreach ($conditions as $attribute => $value) {
                $connectionStatements[] = implode(' = ', [$attribute, '?']);
            }
            $conditionsSql .= implode(' AND ', $connectionStatements);
        }

        $select = $this->buildSelect($select);
        $sql = "SELECT $select FROM $table $conditionsSql";

        $statement = $this->connection->prepare($sql);
        $statement->execute(array_values($conditions));

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $table
     * @param string $primaryKey
     * @param array $attributes
     * @return bool
     */
    public function insert(string $table, string $primaryKey, array $attributes = []): bool
    {
        $attributes = $this->prepareAttributes($attributes, $primaryKey);
        $attributesSql = implode(', ', array_keys($attributes));
        $valueSql = implode(',', array_fill(0, count($attributes), '?'));
        $sql = "INSERT INTO $table ($attributesSql) VALUES ($valueSql)";

        $statement = $this->connection->prepare($sql);

        return $statement->execute(array_values($attributes));
    }

    /**
     * @param string $table
     * @param string $primaryKey
     * @param array $attributes
     * @return bool
     */
    public function update(string $table, string $primaryKey, array $attributes = []): bool
    {
        $primaryKeySql = "$primaryKey = $attributes[$primaryKey]";
        $attributes = $this->prepareAttributes($attributes, $primaryKey);
        $updateStatements =[];

        foreach ($attributes as $attribute)
        {
            $updateStatements[]=implode(' = ',[$attribute, '?']);
        }

        $updateSql = implode(', ', $updateStatements);
        $sql = "UPDATE $table SET $updateSql WHERE $primaryKeySql";
        $statement = $this->connection->prepare($sql);

        return $statement->execute(array_values($attributes));
    }

    /**
     * @param array $attributes
     * @param string $primaryKey
     * @return array
     */
    public function prepareAttributes(array $attributes, string $primaryKey): array
    {
        if (isset($attributes[$primaryKey])) {
            unset($attributes[$primaryKey]);
        }

        return $attributes;
    }

    /**
     * @param string $table
     * @return array
     */
    public function fetchColumns(string $table): array
    {
        $statement = $this->connection->prepare("DESCRIBE $table");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    protected function buildSelect(array $select = []): string
    {
        if(!$select)
        {
            return '*';
        }

        return implode(', ', $select);
    }
}