<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 10/02/14
 * Time: 20:45
 */

namespace Model\Statuses;


use Model\BDD\Connection;

class StatusMapper {

    private $con;

    public function __construct(Connection $connection) {
        $this->con = $connection;
    }

    public static function newId()
    {
        return substr(number_format(time() * rand(),0,'',''),0,10);
    }

    public function persist(Status $status) {

        $query = "INSERT INTO tbl_status VALUES (:id,:datePosted,:lastName,:firstName,:text)";
        $stmt = $this->con->prepare($query);

        $owner = $status->getOwner()->get();
        $stmt->bindValue(':id', $status->getId());
        $stmt->bindValue(':datePosted', date_format($status->getDate(), 'Y-m-d H:i:s'));

        if($owner['pseudo']) {

            var_dump($owner['pseudo']);
            $stmt->bindValue(':lastName', "");
            $stmt->bindValue(':firstName', $owner['pseudo']);
        }
        else {
            $stmt->bindValue(':firstName', $owner['pseudo']);
            $stmt->bindValue(':lastName', $owner['lastName']);
        }

        $stmt->bindValue(':text', $status->getText());

        $stmt->execute();

    }

    public function remove($id) {

        $query = "DELETE FROM tbl_status WHERE id=:id";

        $stmt = $this->con->prepare($query);

        $stmt->bindValue(':id', $id);

        $stmt->execute();

    }

} 