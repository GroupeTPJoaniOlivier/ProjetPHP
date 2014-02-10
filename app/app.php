<?php

require __DIR__ . '/../vendor/autoload.php';


use Http\Request;
use Model\JsonFinder;
use JMS\Serializer;
use Model\BDD\Connection;
use Model\Statuses\Status;
use Model\Statuses\StatusMapper;

/**
 * FORCING AUTOLOADING OF JMS ANNOTATIONS
 */
$t = new JMS\Serializer\Annotation\Type(array('value' => 'string'));


$json_file = __DIR__ . DIRECTORY_SEPARATOR. ".." .DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "statuses.json";


$con = new Connection("root", "espagneelo2k12", "localhost", "mysql", "uframework_db");

$con->executeQuery("SELECT * from tbl_status");


/**
 * Serialization
 */

$serializer = Serializer\SerializerBuilder::create()->build();
// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

/**
 * Index
 * Redirect to /statuses
 */
$app->get('/', function () use ($app) {
    $app->redirect("/statuses");
});

/**
 * GET /statuses
 */
$app->get('/statuses/*', function(Request $request) use ($app, $json_file,$serializer, $con) {

    //$json_finder = new JsonFinder($json_file);
    //$statuses = $json_finder->findAll();

    $format = $request->guessBestFormat();

    $sqlfinder = new \Model\BDD\MySQLFinder($con);
    $statuses = $sqlfinder->findAll();

    if($format == 'json')
    {
        $rep = new \Http\Response($serializer->serialize($statuses, 'json'));
        $rep->send();
    }
    else
    {
        $rep = new \Http\Response($app->render('statuses.php', array('array' => $statuses)));
        $rep->send();
        //return ;
    }
});

/**
 * GET /statuses/id
 */
$app->get('/statuses/(\d+)/*', function(Request $request, $id) use ($app, $con, $json_file,$serializer) {

    //$memory_finder = new \Model\JsonFinder($json_file);
    //$status = $memory_finder->findOneById($id);

    $mysql_finder = new \Model\BDD\MySQLFinder($con);
    $status = $mysql_finder->findOneById($id);

    $format = $request->guessBestFormat();



    if($format == 'json')
    {
        $rep = new \Http\Response($serializer->serialize($status, 'json'));
        $rep->send();
    }
    else
    {
        return $app->render('status.php', array('item' => $status) );
    }

});

/**
 * POST /statuses
 */
$app->post('/statuses/*', function(Request $request) use ($app, $con) {

    $data_mapper = new StatusMapper($con);

    $new_status = new Status(StatusMapper::newId(), new DateTime(), $request->getParameter('username'), $request->getParameter('message'));

    $data_mapper->persist($new_status);

    $app->redirect('/statuses');
});

/**
 * DELETE /statuses/id
 */
$app->delete('/statuses/(\d+)/*', function(Request $request, $id) use ($app, $json_file) {

    $memory_finder = new \Model\JsonFinder($json_file);

    $memory_finder->delete($id);

    $app->redirect('/statuses');

});


return $app;
