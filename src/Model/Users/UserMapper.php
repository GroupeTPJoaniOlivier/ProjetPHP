<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 16/02/14
 * Time: 12:33
 */

namespace Model\Users;


use Model\BDD\Connection;

class UserMapper {

    private $con;

    public function __construct(Connection $connection)
    {
        $this->con = $connection;
    }

    public static function newId()
    {
        return substr(number_format(time() * rand(),0,'',''),0,10);
    }

    public function persist(User $user) {

        $query = "INSERT INTO tbl_users VALUES(:id, :username, :password)";

        $stmt = $this->con->prepare($query);

        $stmt->bindValue(':id', $user->getId());
        $stmt->bindValue(':username', $user->getUsername());
        $stmt->bindValue(':password', $user->getPassword());

        $stmt->execute();

    }

    public function remove($id) {

        $query = "DELETE FROM tbl_users WHERE id=:id";

        $stmt = $this->con->prepare($query);

        $stmt->bindValue(':id', $id);

        $stmt->execute();

    }

} 