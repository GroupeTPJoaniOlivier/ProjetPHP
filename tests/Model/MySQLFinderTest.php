<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 16/02/14
 * Time: 17:44
 */

namespace Model;

use Model\BDD\Connection;
use Model\BDD\MySQLFinder;
use Model\Statuses\Status;
use Model\Statuses\StatusMapper;
use \TestCase;

class MySQLFinderTest extends TestCase {

    private $con;

    public function setUp()
    {
        $this->con = new Connection("root", "espagneelo2k12", "localhost", "mysql", "uframework_db");
    }

    public function testNotExist() {
        $status_finder = new MySQLFinder($this->con);

        $this->assertNull($status_finder->findOneById(250));
    }

    public function testFindAll() {
        $status_finder = new MySQLFinder($this->con);

        $results = $status_finder->findAll();

        $this->assertNotEquals(0,$results);

    }

} 