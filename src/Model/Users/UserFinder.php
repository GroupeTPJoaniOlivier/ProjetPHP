<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 16/02/14
 * Time: 13:06
 */

namespace Model\Users;


use Model\BDD\Connection;
use PDO;
use Model\FinderInterface;

class UserFinder implements FinderInterface {

    private $con;

    public function __construct(Connection $connection)
    {
        $this->con = $connection;
    }

    public function findByUsernameAndPassword($username, $password)
    {
        $query = "SELECT * from tbl_users where username =:username";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(':username', $username);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(password_verify($password, $result['password']))
            return true;
        return false;
    }

    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
        // TODO: Implement findOneById() method.
    }
}