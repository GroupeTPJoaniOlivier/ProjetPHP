<?php

require __DIR__ . '/../autoload.php';

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

$app->get('/statuses', function() use ($app) {

   $memory_finder = new \Model\InMemoryFinder();

   $memory_array = $memory_finder->findAll();

   return $app->render('statuses.php', array('array' => $memory_array));
});

$app->get('/statuses/(\d+)', function($id) use ($app) {

   $memory_array = new \Model\InMemoryFinder();

   $item = $memory_array->findOneById($id);

   return $app->render('status.php', array('item' => $item) );
});


return $app;
