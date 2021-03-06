<?php

namespace Quiz\Repositories;


use Quiz\Models\UserAnswerModel;

class UserAnswerRepository extends BaseRepository
{

    /** Returns the corresponding model class name
     * @return string */
    public static function modelName(): string
    {
        return UserAnswerModel::class;
    }

    /** @return string */
    public static function getTableName(): string
    {
        return 'user_answers';
    }
}