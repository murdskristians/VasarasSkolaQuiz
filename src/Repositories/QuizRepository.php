<?php


namespace Quiz\Repositories;

use Quiz\Models\QuizModel;

class QuizRepository extends BaseRepository
{

    /**Returns the corresponding model class name
     * @return string */
    public static function modelName(): string
    {
        return QuizModel::class;
    }

    /** @return string */
    public static function getTableName(): string
    {
        return 'quizzes';
    }
}