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

$app->get('/index', function () use ($app) {
    return $app->render('index.php');
});

$app->get('/test', function() use ($app) {
   return $app->render('test.php');
});


// Others methods

return $app;
