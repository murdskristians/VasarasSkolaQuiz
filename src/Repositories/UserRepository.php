<?php

namespace Quiz\Repositories;


use Quiz\Models\UserModel;

class UserRepository
{
    private $users = [];
    private $idCounter = 0;

    /**
     * @param UserModel $user
     * @return UserModel
     */
    public function saveOrCreate(UserModel $user): UserModel
    {
        //Check if user exists
        $existingUser = $this->getById($user->id);

        if ($existingUser->isNew()) {
            $this->idCounter += 1;
            $existingUser->id = $this->idCounter;
        }

        $existingUser->name = $user->name;

        $this->users[$existingUser->id] = $existingUser;

        return $existingUser;
    }

    public function getById(int $userId): UserModel
    {
        if (isset($this->users[$userId])) {
            return $this->users[$userId];
        }
        return new UserModel;
    }

    public function getAll(int $userId): UserModel
    {
        if (isset($this->users[$userId])) {
            return $this->users[$userId];
        }
        return new UserModel;
    }
}