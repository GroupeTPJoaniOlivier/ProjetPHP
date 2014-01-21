<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 21/01/14
 * Time: 14:47
 */

namespace Model;


class JsonFinder implements FinderInterface {

    private $file;

    public function __construct($fileName) {

        $this->file = $fileName;

        $status1 = new Status(0, new \DateTime(), "Admin", "Hello world status version !");
        $status2 = new Status(1, new \DateTime(), "Admin", "Just a shiny little status !");
        $status3 = new Status(2, new \DateTime(), "Admin", "Statuses ! More Statuses !");

        //var_dump($status1);

        $status1_json = json_encode($status1);
        $status2_json = json_encode($status2);
        $status3_json = json_encode($status3);

        //var_dump($status1_json);

        $this->json_encode_object($fileName, $status1);

    }

    private function json_encode_object($fileName, Status $object)
    {
        $array = array();

        $array['id'] = $object->getId();
        $array['date'] = $object->getDate();
        $array['owner'] = $object->getOwner();
        $array['text'] = $object->getText();


        echo json_encode($array);

        file_put_contents($fileName, json_encode($array));

    }

    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {

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