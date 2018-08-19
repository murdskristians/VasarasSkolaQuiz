<?php


namespace Quiz\Repositories;

use Quiz\Models\QuestionModel;

class QuestionRepository extends BaseRepository
{

    /** Returns the corresponding model class name
    @return string */
    public static function modelName(): string
    {
        return QuestionModel::class;
    }

    /** @return string */
    public static function getTableName(): string
    {
        return 'questions';
    }
}