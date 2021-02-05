<?php

use App\Utilities\BaseTemplate\Route as Route;
use App\ORM\Database;

use App\Log\Logger;

$db = new Database();

$log = new Logger();

Route::add('/', function () {
    phpinfo();
});

Route::add('/test',  function () use ($db) {
    echo 'test';

    $db->select('info', '*');
    $rows = $db->result();
    var_dump($rows);
}, 'get');

Route::add('/Log',  function () use ($log) {
    echo $log->log('emergency','User {username} created', ['username' => 'bolivar']);

    echo $log->log('emergency','One User created', []);
}, 'get');

Route::add('/id/@id',  function ($id) {
    echo $id;
}, 'get');

Route::add('/t1/@id/t2/@name',  function ($id, $name) {
    echo $id . ' ' . $name;
}, 'get');

Route::add('/t1/@id/t2/@name/t3/@third',  function ($id, $name, $third) {
    echo $id . ' ' . $name . ' ' . $third;
}, 'get');

// Add a 404 not found route
Route::pathNotFound(function($path) {
    // Do not forget to send a status header back to the client
    // The router will not send any headers by default
    // So you will have the full flexibility to handle this case
    header('HTTP/1.0 404 Not Found');
    echo 'Error 404 :-(<br>';
    echo 'The requested path "'.$path.'" was not found!';
});

// Add a 405 method not allowed route
Route::methodNotAllowed(function($path, $method) {
    // Do not forget to send a status header back to the client
    // The router will not send any headers by default
    // So you will have the full flexibility to handle this case
    header('HTTP/1.0 405 Method Not Allowed');
    echo 'Error 405 :-(<br>';
    echo 'The requested path "'.$path.'" exists. But the request method "'.$method.'" is not allowed on this path!';
});

// Run the Router with the given Basepath
Route::run();