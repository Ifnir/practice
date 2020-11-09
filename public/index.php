<?php
/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require_once __DIR__.'/../vendor/autoload.php';

use App\Controller\HomeController;
use App\Utilities\BaseTemplate\BasicRoute;
$test = new HomeController();










