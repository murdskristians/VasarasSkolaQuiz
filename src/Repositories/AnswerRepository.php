<?php


namespace Quiz\Repositories;

use Quiz\Models\AnswersModel;

class AnswerRepository extends BaseRepository
{

    /** Returns the corresponding model class name
    @return string */
    public static function modelName(): string
    {
        return AnswersModel::class;
    }

    /** @return string */
    public static function getTableName(): string
    {
        return 'answers';
    }
}