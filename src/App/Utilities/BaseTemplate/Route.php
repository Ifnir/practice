<?php

namespace App\Utilities\BaseTemplate;

class Route
{
    private static $routes = Array();
    private static $pathNotFound = null;
    private static $methodNotAllowed = null;

    public static function add($expression, $function, $method = 'get')
    {
        array_push(self::$routes, Array(
            'expression' => $expression,
            'function' => $function,
            'method' => $method
        ));
    }

    public static function pathNotFound($function)
    {
        self::$pathNotFound = $function;
    }

    public static function methodNotAllowed($function)
    {
        self::$methodNotAllowed = $function;
    }

    // TODO: Make function to extract the variable in the URI
    public static function run()
    {
        $basepath = '/';
        // Parse current url
        $parsed_url = parse_url($_SERVER['REQUEST_URI']); //Parse Uri

        if(isset($parsed_url['path'])){
            $path = $parsed_url['path'];
        }else{
            $path = '/';
        }

        // Get current request method
        $method = $_SERVER['REQUEST_METHOD'];

        $path_match_found = false;

        $route_match_found = false;

        foreach(self::$routes as $route){

            // If the method matches check the path

            // Add basepath to matching string
            if($basepath != '' && $basepath != '/'){
                $route['expression'] = $route['expression'];
            }
            // Add 'find string start' automatically
            $route['expression'] = preg_quote($route['expression'], '#');

            // start //test/id/@id then //test/id/@id/t2/@name -> maybe make a foreach to replace them all with call back?
            $route['expression'] = preg_replace('/(?<!\\\\)\\\\\*/', '.*?', $route['expression']);

            $route['expression'] = preg_replace_callback('%@([a-zA-Z]+)(\\\\:([^/]+))?%', function($data) {
                $pattern = '[^/]+';
                 // next assign, find multiply, if there is more than 1 in uri
                return '(?P<' . $data[1] . '>' . $pattern . ')';
            }, $route['expression']);

            $route['expression'] = '^' . $route['expression'] . '$';

            // Check path match
            if(preg_match( '#'.$route['expression'].'#', $path,$matches)){


                $path_match_found = true;

                // Check method match
                if(strtolower($method) == strtolower($route['method'])){

                    array_shift($matches);// Always remove first element. This contains the whole string
                    echo var_dump($matches['name']);
                    if($basepath != '' && $basepath != '/'){
                        array_shift($matches); // Remove basepath
                    }

                    // Calls the function from array in the Route::add
                    call_user_func_array($route['function'], $matches);

                    $route_match_found = true;

                    // Do not check other routes
                    break;
                }
            }
        }

        // No matching route was found
        if(!$route_match_found){

            // But a matching path exists
            if($path_match_found){
                header("HTTP/1.0 405 Method Not Allowed");
                if(self::$methodNotAllowed){
                    call_user_func_array(self::$methodNotAllowed, Array($path, $method));
                }
            }else{
                header("HTTP/1.0 404 Not Found");
                if(self::$pathNotFound){
                    call_user_func_array(self::$pathNotFound, Array($path));
                }
            }

        }

    }

    private function regex_callback($data) {
        #echo '<pre>'.print_r($data, true).'</pre>';
        $pattern = '[^/]+';
        if(!empty($data[3])) {
            $pattern = stripslashes($data[3]);
        }
        return '(?P<' . $data[1] . '>' . $pattern . ')';
    }
}