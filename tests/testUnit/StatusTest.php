<?php
require_once 'src/Model/Status.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Status test case.
 */
class StatusTest extends TestCase {
	
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

        $handler = function($errorNumber, $errorString, $errorFile, $errorLine) {
            echo "ERROR INFO\nMessage: $errorString\nFile: $errorFile\nLine: $errorLine\n";
        };
        set_error_handler($handler);

	}

    public function setVerboseErrorHandler()
    {

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
	 * Tests Status->__construct()
	 */
	public function test__construct() { // d'apr�s nicolas, ce test et le test des getter/setter et inutile.
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

