<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 04/02/14
 * Time: 13:57
 */

namespace Model\BDD;



class Connection extends \PDO {

    private $username;
    private $password;
    private $host;
    private $engine;
    private $dbname;


    /**
     * @param $username
     * @param $password
     * @param $host
     * @param $engine
     * @param $dbname
     */
    public function __construct($username, $password, $host, $engine, $dbname)
    {
        $this->username = $username;
        $this->password = $password;
        $this->host = $host;
        $this->engine = $engine;
        $this->dbname = $dbname;

        $dns = $this->engine . ":host=" . $host . ";dbname=" . $dbname;

        parent::__construct($dns, $this->username, $this->password);
    }


    public function executeQuery($query, $parameters = [] )
    {
        $stmt = $this->prepare($query);

        foreach($parameters as $name => $value ) {
            $stmt->bindValue(':' . $name, $value);
        }

        return $stmt->execute();
    }

} 