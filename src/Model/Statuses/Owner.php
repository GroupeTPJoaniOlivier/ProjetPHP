<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 10/02/14
 * Time: 20:51
 */

namespace Model\Statuses;


class Owner {

    private $firstName;

    private $lastName;

    private $pseudo;

    public function __construct() {

    }

    private function fill(array $parts) {

        if(array_key_exists('pseudo', $parts)) {
            $this->pseudo = $parts['pseudo'];
        }
        else {
            $this->firstName = $parts['firstName'];
            $this->lastName = $parts['lastName'];
        }
    }

    public static function createWithPseudo($pseudo) {

        $instance = new self();
        $parts = ['pseudo' => $pseudo];
        $instance->fill($parts);

        return $instance;
    }

    public static function create($firstName, $lastName) {
        $instance = new self();

        $parts = ['firstName' => $firstName,
                  'lastName' => $lastName];

        $instance->fill($parts);

        return $instance;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    public function get() {

        if($this->pseudo)
            return ['pseudo' => $this->pseudo];

        $owner = ['firstName' => $this->firstName,'lastName' => $this->lastName];
        return $owner;

    }
} 