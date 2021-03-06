<?php

namespace Quiz\Repositories;


use Quiz\Models\ResultModel;

class ResultRepository extends BaseRepository
{

    /**Returns the corresponding model class name
     * @return string */
    public static function modelName(): string
    {
        return ResultModel::class;
    }

    /** @return string */
    public static function getTableName(): string
    {
        return 'results';
    }
}