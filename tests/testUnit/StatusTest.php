<?php
require_once 'src/Model/Status.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Status test case.
 */
class StatusTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var Status
	 */
	private $Status;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {// a vérifier
		parent::setUp ();
		$this->Status = new Status("40","2014-01-23 16:55:44","Joani","status test");
		$this->assertNotNull($this->Status);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->Status = null;
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		//rien a faire ici.
	}
	
	/**
	 * Tests Status->__construct()
	 */
	public function test__construct() {//a vérifier
		$this->Status->__construct("40",new DateTime(),"Joani","status test");
		$this->assertNotNull($this->Status);
	}
	
	/**
	 * Tests Status->getId()
	 */
	public function testGetId() {
		$this->Status = new Status("40",new DateTime(),"Joani","status test");
		$this->assertEquals("40", $this->Status->getId());
	}
	
	/**
	 * Tests Status->getDate()
	 */
	public function testGetDate() {
		$this->Status = new Status("40",new DateTime(),"Joani","status test");
		$this->assertEquals("la date que on doit obtenir", $this->Status->getDate());
	}
	
	/**
	 * Tests Status->getOwner()
	 */
	public function testGetOwner() {
		$this->Status = new Status("40",new DateTime(),"Joani","status test");
		$this->assertEquals("Joani", $this->Status->getOwner());
	}
	
	/**
	 * Tests Status->getText()
	 */
	public function testGetText() {
		$this->Status = new Status("40",new DateTime(),"Joani","status test");
		$this->assertEquals("status test", $this->Status->getText());
	}
}

