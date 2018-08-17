<?php

include_once '../vendor/autoload.php';

use Quiz\Repositories\UserDatabaseRepository;
use Quiz\Repositories\UserRepository;

//$repo = new UserDatabaseRepository();
//$repo->getConnection();
//$data = $repo->getById(2);
//
//var_dump($data);

$userRepo = new UserDatabaseRepository();

$user = $userRepo->getById(1);
var_dump($user);