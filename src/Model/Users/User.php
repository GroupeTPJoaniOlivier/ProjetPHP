<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 16/02/14
 * Time: 12:32
 */

namespace Model\Users;


class User {

    private $id;

    private $username;

    private $password;

    public function __construct($id,$username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }


} 