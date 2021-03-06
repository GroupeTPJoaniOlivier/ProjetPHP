<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 21/01/14
 * Time: 14:47
 */

namespace Model;
use JMS\Serializer;
use JMS\Serializer\Annotation\Type;



class JsonFinder implements FinderInterface {

    private $file;

    public function __construct($fileName) {

        $this->file = $fileName;

    }

    private function json_encode_object($fileName, Status $object)
    {
        // Creating array from object
        $array_to_encode = $this->create_array_from_object($object);

        // Decoding json file to retrieve the saved array

        $array_decode = json_decode(file_get_contents($fileName), true);

        foreach($array_decode as $item)
        {
            $item_raw_id = $item['id'];
            if($item_raw_id == $object->getId())
            {
                // If the object id is found, we break of the function
                    return;
            }
        }

        // If the id of the status is not found
        $array_decode[] = $array_to_encode;

        //var_dump(count($array_decode));

        // Write to file the new array
        file_put_contents($fileName, json_encode($array_decode, JSON_FORCE_OBJECT) . "\n");
    }

    private function create_status_list_from_array($array_decode)
    {
        $status_array = array();

        foreach($array_decode as $item)
        {
            $status_array[] = $this->create_status_from_array($item);
        }

        return $status_array;

    }

    private function create_status_from_array($item)
    {
        $status_id = $item['id'];
        $status_owner = $item['object'][1]['owner'];
        $status_text = $item['object'][2]['text'];
        $status_date = $item['object'][0]['date'];
        $status_real_date = new \DateTime($status_date['date'], new \DateTimeZone($status_date['timezone']));

        return new Status($status_id, $status_real_date, $status_owner, $status_text);
    }

    private function create_object_from_array($array_decode, $id)
    {
        foreach($array_decode as $item)
        {
            if($item['id'] == $id)
            {
                //var_dump($item['object'][1]['owner']);
                return $this->create_status_from_array($item);
            }
        }
    }

    private function create_array_from_object(Status $object)
    {
        $array = array();

        $array[] = array( 'date' => $object->getDate());
        $array[] = array( 'owner' => $object->getOwner());
        $array[] = array( 'text' => $object->getText());

        $array_to_encode['id'] = $object->getId();
        $array_to_encode['object'] = $array;

        return $array_to_encode;
    }

    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
        $array_decode = json_decode(file_get_contents($this->file), true);

        return $this->create_status_list_from_array($array_decode);

    }

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
        $array_decode = json_decode(file_get_contents($this->file), true);

        if($status = $this->create_object_from_array($array_decode, $id))
            return $status;

        return null;
    }

    public function newId()
    {
        return substr(number_format(time() * rand(),0,'',''),0,10);
    }

    public function addNewStatus(Status $status)
    {
        $this->json_encode_object($this->file, $status);
    }

    public function delete($id)
    {
        $array_decode = json_decode(file_get_contents($this->file), true);

        $status_array = $this->create_status_list_from_array($array_decode);

        //var_dump($id);

        //var_dump("OLD array size : " . count($status_array));
        $new_array = array();

        foreach($status_array as $status)
        {
            //var_dump($status->getId());
            if($status->getId() != $id)
            {
                $new_array[] = $status;
            }
        }

        //var_dump("New array : " . count($new_array));


        $array_to_write = array();
        foreach($new_array as $status)
        {
            $array_to_write[] = $this->create_array_from_object($status);
        }

        file_put_contents($this->file, json_encode($array_to_write, JSON_FORCE_OBJECT) . "\n");

    }
}