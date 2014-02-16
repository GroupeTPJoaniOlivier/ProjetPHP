<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 04/02/14
 * Time: 14:39
 */

namespace Model\BDD;

use Model\Statuses\Status;
use PDO;
use Model\FinderInterface;

class MySQLFinder implements FinderInterface {

    private $connection;

    public function __construct(Connection $con) {
        $this->connection = $con;
    }

    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
        $status_array = [];
        $query = "SELECT * from tbl_status";

        foreach($this->connection->query($query) as $status)
        {
            $status = new Status($status['id'],
                                 new \DateTime($status['posted_date']),
                                 $status['owner_id'],
                                 $status['text']);

            $status_array[] = $status;
        }

        return $status_array;
    }

    public function findByOwnerId($owner_id) {
        $status_array = [];

        $query = "SELECT * from tbl_status WHERE owner_id=:owner_id";

        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(':owner_id',$owner_id);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($results as $status)
        {
            $status = new Status($status['id'],
                new \DateTime($status['posted_date']),
                $status['owner_id'],
                $status['text']);

            $status_array[] = $status;
        }

        return $status_array;

    }

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed $id
     * @return null|mixed
     */
    public function findOneById($id)
    {
        $query = "SELECT * from tbl_status where id =:id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(':id', $id);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result !== false)
        {
            $status = new Status($result['id'],
                new \DateTime($result['posted_date']),
                $result['owner_id'],
                $result['text']);

            return $status;
        }

        return null;

    }
    
    /** find elements which correspond to the request
     * @param array $criteria 
     * @return null|mixed 
     */
    public function find($criteria)
    {
    	$status_array = [];
    	$query = $this->createRequest($criteria);
    	
    	foreach($this->connection->query($query) as $status)
    	{
    		$status = new Status($status['id'],
    				new \DateTime($status['posted_date']),
    				$status['owner_id'],
    				$status['text']);
    	
    		$status_array[] = $status;
    	}
    	
    	return $status_array;
    }
    
    public function createRequest($criteria)
    {
    	$clause_limit = [];
    	$clause_orderby = [];
    	
    	foreach ($criteria as $key => $value)
    	{
    		if($key === "limit")
    			$clause_limit[] = $value;
    		if($key === "orderBY")
    			$clause_orderby[] = $value;
    	}
    	
    	$query = "SELECT * from tbl_status "; 
    	$query .= "ORDER BY " .$clause_orderby [0];
    	$query .= "LIMIT " .$clause_limit[0];
    	
    	return $query;
    }
}