<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 16/02/14
 * Time: 22:11
 */

namespace Model;


use Model\BDD\Connection;
use Model\Users\UserFinder;

class UserTest extends \TestCase {

    private $con;

    public function setUp()
    {
        $this->con = new Connection("root", "espagneelo2k12", "localhost", "mysql", "uframework_db");
    }

    public function testNotExists()
    {
        $user_finder = new UserFinder($this->con);
        $user = $user_finder->findOneById(15);

        $this->assertNull($user);
    }

    public function testFindAll()
    {
        $user_finder = new UserFinder($this->con);
        $users = $user_finder->findAll();

        $this->assertNotEquals(0, count($users));
    }



}
 