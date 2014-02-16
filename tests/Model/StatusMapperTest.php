<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 16/02/14
 * Time: 22:00
 */

namespace Model;


use Model\BDD\Connection;
use Model\BDD\MySQLFinder;
use Model\Statuses\Status;
use Model\Statuses\StatusMapper;

class StatusMapperTest extends \TestCase {

    private $con;

    public function setUp()
    {
        $this->con = new Connection("root", "espagneelo2k12", "localhost", "mysql", "uframework_db");
    }


    public function testPersist()
    {
        $status = new Status(10, new \DateTime(), 15, "Test status");

        $status_finder = new MySQLFinder($this->con);
        $number = $status_finder->findAll();
        $status_mapper = new StatusMapper($this->con);
        $status_mapper->persist($status);
        $status = $status_finder->findOneById(10);
        $this->assertEquals(10, $status->getId());

        // Clean
        $status_mapper->remove(10);
    }

    public function testRemove()
    {
        // Adding a status
        $status = new Status(10, new \DateTime(), 15, "Test status");

        $status_finder = new MySQLFinder($this->con);
        $status_mapper = new StatusMapper($this->con);


        $status_mapper->persist($status);

        $number = count($status_finder->findAll());

        $status_mapper->remove(10);

        $number2 = count($status_finder->findAll());

        $this->assertNotEquals($number, $number2);

    }



}
 