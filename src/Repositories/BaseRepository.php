<?php
namespace Quiz\Repositories;
use Quiz\Interfaces\ConnectionInterface;
use Quiz\Interfaces\RepositoryInterface;
use Quiz\Models\BaseModel;
abstract class BaseRepository implements RepositoryInterface
{
    /** @var ConnectionInterface */
    private $connection;
    /**
     * @param array $conditions
     * @return static[]
     */
    public function all(array $conditions = []): array
    {
        $dataArray = $this->connection->select(static::getTableName(), $conditions);
        $instances = [];
        foreach ($dataArray as $data) {
            $instances[] = $this->init($data);
        }
        return $instances;
    }
    /**
     * @return string
     */
    abstract public static function getTableName(): string;
    /**
     * @return string
     */
    public static function getPrimaryKey(): string
    {
        return 'id';
    }
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }
    /**
     * @param array $attributes
     * @return BaseModel
     */
    public function init(array $attributes)
    {
        $class = static::modelName();
        /** @var BaseModel $instance */
        $instance = new $class;
        $instance->setAttributes($attributes);
        return $instance;
    }
    /**
     * @param array $attributes
     * @return BaseModel
     */
    public function initLoaded(array $attributes)
    {
        $instance = $this->init($attributes);
        $instance->isNew = false;
        return $instance;
    }
    /**
     * @param int $id
     * @return BaseModel
     */
    public function getById(int $id)
    {
        return $this->one(['id' => $id]);
    }
    /**
     * @param array $conditions
     * @param array $select
     * @return BaseModel
     */
    public function one(array $conditions = [], array $select = [])
    {
        $data = array_first($this->connection->select(static::getTableName(), $conditions, $select));
        if (!$data) {
            return null;
        }
        return $this->initLoaded($data);
    }
    /**
     * @param BaseModel $model
     * @return bool
     */
    public function save($model): bool
    {
        $connection = $this->connection;
        if ($model->isNew) {
            $connection->insert(static::getTableName(), static::getPrimaryKey(), $this->getAttributes($model));
            $model->id = $connection->getLastInsertId();
            $this->prepareAttributes($model);
        }
        return $connection->update(static::getTableName(), static::getPrimaryKey(), $this->getAttributes($model));
    }
    /**
     * @param BaseModel $model
     * @return array
     */
    public function getAttributes($model): array
    {
        $model = $this->prepareAttributes($model);
        return $model->attributes;
    }
    /**
     * @param $model
     * @return BaseModel
     */
    protected function prepareAttributes($model)
    {
        $columns = $this->connection->fetchColumns(static::getTableName());
        $attributes = [];
        foreach ($columns as $column) {
            $key = BaseModel::snakeCaseToCamelCase($column);
            if (property_exists(static::modelName(), $key)) {
                $attributes[$column] = $model->{$key};
            }
        }
        $model->attributes = $attributes;
        return $model;
    }
    /**
     * @param array $attributes
     * @return BaseModel
     */
    public function create(array $attributes = [])
    {
        return $this->init($attributes);
    }
}