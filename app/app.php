<?php

use Http\Request;

require __DIR__ . '/../autoload.php';
define(FILE_APPEND, 1);

$json_file = __DIR__ . DIRECTORY_SEPARATOR. ".." .DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "statuses.json";

// Config
$debug = true;

$app = new \App(new View\TemplateEngine(
    __DIR__ . '/templates/'
), $debug);

/**
 * Index
 */
$app->get('/', function () use ($app) {
    return $app->render('index.php');
});

$app->get('/statuses/*', function(Request $request) use ($app, $json_file) {

    $memory_finder = new \Model\JsonFinder($json_file);
    $statuses = $memory_finder->findAll();

    if($statuses !== null)
    {
        return $app->render('statuses.php', array('array' => $statuses));
    }
    else
    {
        // TODO: generate not found exception
    }
});

$app->get('/statuses/(\d+)/*', function($id) use ($app, $json_file) {

    $memory_finder = new \Model\JsonFinder($json_file);
    $status = $memory_finder->findOneById($id);

   /*
   $memory_array = new \Model\InMemoryFinder();
   $item = $memory_array->findOneById($id);*/

   return $app->render('status.php', array('item' => $status) );
});


$app->post('/statuses/{0,1}', function(Request $request) use ($app,$json_file) {

    $memory_finder = new \Model\JsonFinder($json_file);

    $new_status = new \Model\Status($memory_finder->newId(), new DateTime(), $request->getParameter('username'), $request->getParameter('message'));

    var_dump($new_status);

    $memory_finder->addNewStatus($new_status);

    $app->redirect('/statuses');
});

$app->delete('/statuses/(\d+)/*', function($id) use ($app) {



});


return $app;
