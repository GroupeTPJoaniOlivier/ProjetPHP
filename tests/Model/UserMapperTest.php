<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 16/02/14
 * Time: 22:20
 */

namespace Model;


use Model\BDD\Connection;
use Model\Users\User;
use Model\Users\UserFinder;
use Model\Users\UserMapper;

class UserMapperTest extends \PHPUnit_Framework_TestCase {

    private $con;

    public function setUp()
    {
        $this->con = new Connection("root", "espagneelo2k12", "localhost", "mysql", "uframework_db");
    }

    public function testPersist()
    {
        $user = new User(15, "TestUser", "test");

        $user_finder = new UserFinder($this->con);
        $user_mapper = new UserMapper($this->con);
        $user_mapper->persist($user);
        $user2 = $user_finder->findOneById(15);
        $this->assertEquals(15, $user2->getId());

        // Clean
        $user_mapper->remove(15);
    }

    public function testRemove()
    {
        $user = new User(15, "TestUser", "test");

        $user_finder = new UserFinder($this->con);
        $user_mapper = new UserMapper($this->con);

        $user_mapper->persist($user);
        $number1 = count($user_finder->findAll());
        $user_mapper->remove(15);
        $number2 = count($user_finder->findAll());

        $this->assertNotEquals($number2, $number1);
    }



}
 