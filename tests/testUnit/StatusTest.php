<?php
require_once 'src/Model/Statuses/Status.php';

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
	protected function setUp() {
		parent::setUp ();
		$this->Status = new Status("42","2000-01-01","Olivier","status test");
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
	}
	
	
	/**
	 * Tests Status->getId()
	 */
	public function testGetId() {
		$this->assertEquals(42, $this->Status->getId());
	}
	
	/**
	 * Tests Status->getDate()
	 */
	public function testGetDate() {
		$this->assertEquals("2000-01-01", $this->Status->getDate());
	}
	
	/**
	 * Tests Status->getOwner()
	 */
	public function testGetOwner() {
		
		$this->assertEquals("Olivier", $this->Status->getOwner());
	}
	
	/**
	 * Tests Status->getText()
	 */
	public function testGetText() {
		// TODO Auto-generated StatusTest->testGetText()
		$this->markTestIncomplete ( "getText test not implemented" );
		
		$this->assertEquals("status test",$this->Status->getText());
	}
}

