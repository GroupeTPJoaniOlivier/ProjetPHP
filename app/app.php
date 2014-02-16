<?php

require __DIR__ . '/../vendor/autoload.php';


use Http\Request;
use Model\JsonFinder;
use JMS\Serializer;
use Model\BDD\Connection;
use Model\Statuses\Status;
use Model\Statuses\StatusMapper;
use Model\BDD\MySQLFinder;
use Http\Response;
use Model\Users\User;
use Model\Users\UserFinder;
use Model\Users\UserMapper;

/**
 * FORCING AUTOLOADING OF JMS ANNOTATIONS
 */
$t = new JMS\Serializer\Annotation\Type(array('value' => 'string'));


$json_file = __DIR__ . DIRECTORY_SEPARATOR. ".." .DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "statuses.json";
$con = new Connection("root", "espagneelo2k12", "localhost", "mysql", "uframework_db");

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
 * Listener
 */
$app->addListener('process.before', function(Request $request) use ($app) {

    session_start();

    $allowed = [
        '/login' => [Request::GET, Request::POST],
        '/statuses' => [Request::GET],
        '/signIn' => [Request::GET, Request::POST],
        '/' => [Request::GET]
    ];

    // If the user is already authenticated
    if(isset($_SESSION['is_authenticated'])
        && true === $_SESSION['is_authenticated']) {
        return;
    }

    // If the user can access it without being authenticated
    foreach($allowed as $pattern => $methods) {
        if(preg_match(sprintf('#^%s$#', $pattern), $request->getUri())
            && in_array($request->getMethod(), $methods)) {
            return;
        }
    }

    switch($request->guessBestFormat()) {
        case 'json':
            throw new HttpException(401);
    }

    $app->redirect('/login');

});

/**
 * GET /statuses
 */
$app->get('/statuses/*', function(Request $request) use ($app, $json_file,$serializer, $con) {

    //$json_finder = new JsonFinder($json_file);
    //$statuses = $json_finder->findAll();

    $format = $request->guessBestFormat();

    $sqlfinder = new MySQLFinder($con);
    $statuses = $sqlfinder->findAll();

    if($format == 'json')
    {
        $rep = new Response($serializer->serialize($statuses, 'json'));
        $rep->send();
    }
    else
    {
        $rep = new Response($app->render('statuses.php', array('array' => $statuses)));
        $rep->send();
    }
});

/**
 * GET /statuses/id
 */
$app->get('/statuses/(\d+)/*', function(Request $request, $id) use ($app, $con, $json_file,$serializer) {

    $mysql_finder = new MySQLFinder($con);
    $status = $mysql_finder->findOneById($id);

    $format = $request->guessBestFormat();

    if($format == 'json')
    {
        $rep = new Response($serializer->serialize($status, 'json'));
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

    $new_status = new Status(StatusMapper::newId(),
                                new DateTime(),
                                $request->getParameter('username'),
                                $request->getParameter('message'));

    $data_mapper->persist($new_status);

    $app->redirect('/statuses');
});

/**
 * DELETE /statuses/id
 */
$app->delete('/statuses/(\d+)/*', function(Request $request, $id) use ($app, $con) {

    $data_mapper = new StatusMapper($con);

    $data_mapper->remove($id);

    $app->redirect('/statuses');

});

$app->get('/login', function(Request $request) use($app) {

    $rep = new Response($app->render('login.php'));

    $rep->send();

});

$app->post('/login', function(Request $request) use($app, $con) {

    $user = $request->getParameter('username');
    $pass = $request->getParameter('password');

    $user_finder = new UserFinder($con);

    $user_exists = $user_finder->findByUsernameAndPassword($user, $pass);

    if($user_exists)
    {
        $_SESSION['is_authenticated'] = true;
        $_SESSION['username'] = $user;

        $app->redirect('/statuses');
    }
    else
    {
        return $app->render('login.php', ['user' => $user]);
    }
});

$app->get('/logout', function(Request $request) use ($app) {
    session_destroy();

    $app->redirect('/');
});


$app->get('/signIn', function(Request $request) use ($app) {

    $rep = new Response($app->render('signin.php'));

    $rep->send();

});

$app->post('/signIn', function(Request $request) use ($app, $con) {

    $username = $request->getParameter('username');
    $password = $request->getParameter('password');
    $passwordconfirm = $request->getParameter('passwordconfirm');

    if($password === $passwordconfirm)
    {
        $user_mapper = new UserMapper($con);
        $user = new User($username, $password);

        var_dump($user->getPassword());

        $user_mapper->persist($user);
        $app->redirect('/statuses');
    }

    return $app->render('signin.php', ['username' => $username, 'password' => $password]);

});

return $app;
