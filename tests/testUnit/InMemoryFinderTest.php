<?php
use Model\Status;
require_once 'src/Model/InMemoryFinder.php';
require_once 'tests/TestCase.php';

/**
 * Inutile car cette classe n'est plus utilisé dans le programme.
 * InMemoryFinder test case.
 */
class InMemoryFinderTest extends TestCase {
	
	/**
	 *
	 * @var InMemoryFinder
	 */
	private $InMemoryFinder;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		$this->InMemoryFinder = new InMemoryFinder();
		$this->assertNotNull($this->InMemoryFinder);
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->InMemoryFinder = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Tests InMemoryFinder->__construct()
	 */
	public function test__construct() {		
		$this->InMemoryFinder->__construct();
		$this->assertNotNull($this->InMemoryFinder);
	}
	
	/**
	 * Tests InMemoryFinder->findAll()
	 */
	public function testFindAllnotnull() {
		$this->InMemoryFinder->__construct();
		$this->assertNotNull($this->InMemoryFinder->findAll());//on s'assure que la liste renvoyer n'est pas nulle
	}
	
	public function testFindAllsize() {
		$this->InMemoryFinder->__construct();//on s'assure que la liste renvoyer contient les 3 définis dans le constructeur
		$this->assertEquals(3, count($this->InMemoryFinder->findAll())); 
	}
	
	/**
	 * Tests InMemoryFinder->findOneById()
	 */
	public function testFindOneById() {
		$this->status = new Status(1, new \DateTime(), "Admin", "Just a shiny little status !");
		$this->assertEquals($this->status, $this->InMemoryFinder->findOneById(1));
	}
}

