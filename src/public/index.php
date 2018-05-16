<?php
if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params(3600);
    session_start();
}

/**
 * Require the autoload script, this will automatically load our classes
 * so we don't have to require a class everytime we use a class. Evertime
 * you create a new class, remember to runt 'composer update' in the terminal
 * otherwise your classes may not be recognized.
 */
require_once '../../vendor/autoload.php';

/**
 * Here we are creating the app that will handle all the routes. We are storing
 * our database config inside of 'settings'. This config is later used inside of
 * the container inside 'App/container.php'
 */

$container = require '../App/container.php';
$app = new \Slim\App($container);
$auth = require '../App/auth.php';
require '../App/cors.php';


/********************************
 *          ROUTES              *
 ********************************/


$app->get('/', function ($request, $response, $args) {
    /**
     * This fetches the 'index.php'-file inside the 'views'-folder
     */
    return $this->view->render($response, 'index.php');
});


/**
 * I added basic inline login functionality. This could be extracted to a
 * separate class. If the session is set is checked in 'auth.php'
 */
$app->post('/login', function ($request, $response, $args) {
    /**
     * Everything sent in 'body' when doing a POST-request can be
     * extracted with 'getParsedBody()' from the request-object
     * https://www.slimframework.com/docs/v3/objects/request.html#the-request-body
     */
    $body = $request->getParsedBody();
    $fetchUserStatement = $this->db->prepare('SELECT * FROM users WHERE username = :username');
    $fetchUserStatement->execute([
        ':username' => $body['username']
    ]);
    $user = $fetchUserStatement->fetch();
    if (password_verify($body['password'], $user['password'])) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['userID'] = $user['id'];
        return $response->withJson(['data' => [ $user['id'], $user['username'] ]]);
    }
    return $response->withJson(['error' => 'wrong password']);
});

/**
 * Basic implementation, implement a better response
 */
$app->get('/logout', function ($request, $response, $args) {
    session_destroy();
    return $response->withJson('Success');
});


/**
 * The group is used to group everything connected to the API under '/api'
 * This was done so that we can check if the user is authed when calling '/api'
 * but we don't have to check for auth when calling '/signin'
 */
$app->group('/api', function () use ($app) {

  // GET http://localhost:XXXX/api/todos
  $app->get('/posts', function ($request, $response, $args) {
      $allTodos = $this->todos->getAll();
      return $response->withJson(['data' => $allTodos]);
  });

  // GET http://localhost:XXXX/api/users
  $app->get('/users', function ($request, $response, $args) {
      $allTodos = $this->todos->getAllFromUsers();
      return $response->withJson(['data' => $allTodos]);
  });
  // GET http://localhost:XXXX/api/[table]/id
  $app->get('/{table}/{id}', function ($request, $response, $args) {
      $id = $args['id'];
      $table = $args['table'];
      $singleTodo = $this->todos->getOne($table,$id);
      return $response->withJson(['data' => $singleTodo]);
  });

    // POST http://localhost:XXXX/api/todos
    $app->post('/todos', function ($request, $response, $args) {
        $body = $request->getParsedBody();
        $newTodo = $this->todos->add($body);
        return $response->withJson(['data' => $newTodo]);
    });
});

$app->run();
