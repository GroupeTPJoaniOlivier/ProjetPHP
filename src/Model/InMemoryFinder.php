<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 20/01/14
 * Time: 22:58
 */

namespace Model;


class InMemoryFinder implements FinderInterface {

    private $statuses = array();

    public function __construct()
    {
        $this->statuses[0] = new Status(0, new \DateTime(), "Admin", "Hello world status version !");
        $this->statuses[1] = new Status(1, new \DateTime(), "Admin", "Just a shiny little status !");
        $this->statuses[2] = new Status(2, new \DateTime(), "Admin", "Statuses ! More Statuses !");
    }

    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
        return $this->statuses;
    }

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
        return $this->statuses[$id];
    }
}