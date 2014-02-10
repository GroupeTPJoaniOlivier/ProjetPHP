<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 04/02/14
 * Time: 14:39
 */

namespace Model\BDD;

use Model\Statuses\Status;
use PDO;
use Model\FinderInterface;

class MySQLFinder implements FinderInterface {

    private $connection;

    public function __construct(Connection $con) {
        $this->connection = $con;
    }

    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
        $status_array = [];
        $query = "SELECT * from tbl_status";

        foreach($this->connection->query($query) as $status)
        {
            $status = new Status($status['id'],
                                 new \DateTime($status['posted_date']),
                                 $status['owner_lastname'] . " ". $status['owner_firstname'],
                                 $status['text']);

            $status_array[] = $status;
        }

        return $status_array;
    }

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
        $query = "SELECT * from tbl_status where id =:id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':id', $id);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $status = new Status($result['id'],
            new \DateTime($result['posted_date']),
            $result['owner_lastname'] . " ". $result['owner_firstname'],
            $result['text']);

        return $status;

    }
}