<?php

use Http\Request;

require __DIR__ . '/../vendor/autoload.php';
define(FILE_APPEND, 1);

$json_file = __DIR__ . DIRECTORY_SEPARATOR. ".." .DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "statuses.json";

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
$app->get('/statuses/*', function(Request $request) use ($app, $json_file) {

    $memory_finder = new \Model\JsonFinder($json_file);
    $statuses = $memory_finder->findAll();

    return $app->render('statuses.php', array('array' => $statuses));
});

/**
 * GET /statuses/id
 */
$app->get('/statuses/(\d+)/*', function(Request $request, $id) use ($app, $json_file) {

    $memory_finder = new \Model\JsonFinder($json_file);
    $status = $memory_finder->findOneById($id);

   return $app->render('status.php', array('item' => $status) );
});

/**
 * POST /statuses
 */
$app->post('/statuses/*', function(Request $request) use ($app,$json_file) {

    $memory_finder = new \Model\JsonFinder($json_file);

    $new_status = new \Model\Status($memory_finder->newId(), new DateTime(), $request->getParameter('username'), $request->getParameter('message'));

    $memory_finder->addNewStatus($new_status);

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
