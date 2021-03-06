<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 20/01/14
 * Time: 23:05
 */

namespace Model\Statuses;

use JMS\Serializer\Annotation as JMS;
use Model\Statuses\Owner;

class Status {

    private $id;

    /**
     * @JMS\Type("DateTime<'Y-m-d'>")
     */
    private $date;
    private $owner;
    private $text;

    public function __construct($id, $date,$owner,$text)
    {
        $this->date = $date;
        $this->id = $id;
        $this->owner = $owner;
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

} 