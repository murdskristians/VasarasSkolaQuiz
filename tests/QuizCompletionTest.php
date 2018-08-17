<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

//class UserRegistrationTest extends TestCase
//{
//
//    public function tearDown()
//    {
//        parent::tearDown();
//        \Mockery::close();
//    }
//
//    public function test_withRightData_insertsUser()
//    {
//        $email = 'foo@bar.lv';
//        $password = 'super secret';
//
//        $repo = \Mockery::mock(new UserRepository());
//        $repo->shouldReceive('addUser')->with($email, $password)->once()->andReturn(3);
//        $service = new UserRegistrationService($repo);
//        $id = $service->registerUser($email, $password);
//
//        $this->assertEquals(3, $id);
//
//    }
//}
//
//class UserRegistrationService
//{
//    /**
//     * @var UserRepository
//     */
//    private $userRepository;
//
//    public function __construct(UserRepository $userRepository)
//    {
//        $this->userRepository = $userRepository;
//    }
//    public function registerUser(string $email, string $password)
//    {
//        // validation
//
//        // insert
//        $userId = $this->userRepository->addUser($email, $password);
//
//        // send email
//        return $userId;
//    }
//}
//
//class UserRepository
//{
//    public function addUser(string $email, string $password)
//    {
//        var_dump(123);
//        // super heavy DB query
//        //...
//        return 3;
//    }
//}