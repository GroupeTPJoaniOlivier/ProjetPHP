<?php

require __DIR__ . '/../autoload.php';

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

$app->get('/statuses/*', function() use ($app, $json_file) {

   $memory_finder = new \Model\JsonFinder($json_file);
/*
   $memory_finder = new \Model\InMemoryFinder();
   $memory_array = $memory_finder->findAll();*/

   return $app->render('statuses.php', array('array' => $memory_array));
});



$app->get('/statuses/(\d+)/*', function($id) use ($app) {



/*
   $memory_array = new \Model\InMemoryFinder();
   $item = $memory_array->findOneById($id);*/

   return $app->render('status.php', array('item' => $item) );
});


$app->post('/statuses/{0,1}', function() use ($app) {



});

$app->delete('/statuses/(\d+)/*', function($id) use ($app) {



});


return $app;
