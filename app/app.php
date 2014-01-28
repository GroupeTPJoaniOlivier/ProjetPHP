<?php

require __DIR__ . '/../vendor/autoload.php';


use Http\Request;
use Model\JsonFinder;
use JMS\Serializer;

/**
 * FORCING AUTOLOADING OF JMS ANNOTATIONS
 */
$t = new JMS\Serializer\Annotation\Type(array('value' => 'string'));


$json_file = __DIR__ . DIRECTORY_SEPARATOR. ".." .DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "statuses.json";

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
$app->get('/statuses/*', function(Request $request) use ($app, $json_file,$serializer) {

    $json_finder = new JsonFinder($json_file);
    $statuses = $json_finder->findAll();

    $format = $request->guessBestFormat();

    if($format == 'json')
    {
        $rep = new \Http\Response($serializer->serialize($statuses, 'json'));
        $rep->send();
    }
    else
    {
        return $app->render('statuses.php', array('array' => $statuses));
    }
});

/**
 * GET /statuses/id
 */
$app->get('/statuses/(\d+)/*', function(Request $request, $id) use ($app, $json_file,$serializer) {

    $memory_finder = new \Model\JsonFinder($json_file);
    $status = $memory_finder->findOneById($id);

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
$app->post('/statuses/*', function(Request $request) use ($app,$json_file, $serializer) {

    $json_finder = new \Model\JsonFinder($json_file);

    $new_status = new \Model\Status($json_finder->newId(), new DateTime(), $request->getParameter('username'), $request->getParameter('message'));
    $json_finder->addNewStatus($new_status);

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
