<?php


namespace Quiz\Repositories;

use Quiz\Models\UserModel;

class UserDatabaseRepository extends BaseDatabaseRepository
{
    public static function modelName(): string
    {
        return UserModel::class;
    }

    public static function getTableName(): string
    {
        return "users";
    }
}