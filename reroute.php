<?php
/**  
 *  reroute.php -- minimal router class that allows use of regex to define paths.
 *  @author Philip Conrad
 *  @copyright Philip Conrad 3/23/2012
 *
 *  Defining Paths:
 *  - Make a closure that knows which file to load.
 *  -- Ex: `create_function('' , "\$output = include './pages/home.html'; sprintf(\$output);"));`
 *  - call `$router->add('/path/to/something', $closure);`
 *
 *  Using the Router:
 *  - call `$router->run()` when you're done adding paths. This is a *fire-and-forget* library.
 *
 *   <pre>   
 *   Copyright 2012 Philip Conrad
 *
 *   Licensed under the Apache License, Version 2.0 (the "License");
 *   you may not use this file except in compliance with the License.
 *   You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 *   Unless required by applicable law or agreed to in writing, software
 *   distributed under the License is distributed on an "AS IS" BASIS,
 *   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *   See the License for the specific language governing permissions and
 *   limitations under the License.
 *   </pre>
*/

class Reroute {

    // Element format: path => closure;
    public $routeList = array();


    // Get url only -> remove stuff after the .filetype -> if it's null, make it a '/'.
    private function urlstrip($str) {
        $str = parse_url($str);
        $str = $str["path"];
        $str = explode('.', $str);
        $str = $str[0];
        $str = isset($str) ? "/" . $str : $str;
        return $str;
    }

    public function add($route, $function) {
        $this->routeList[$route] = $function;
    }

    public function run() {
        $defaultfun = create_function ( '', "\$output = include './pages/404.html'; sprintf(\$output);" );

        $uri = isset($_REQUEST['uri']) ? $_REQUEST['uri'] : '';

        $uri = $this->urlstrip($uri);

        $callback = $defaultfun;

        foreach ($this->routeList as $path => $fun) {
            if ($uri == $path) {
                $callback = $this->routeList[$uri]; //value will be the function closure we need.
            }
        }

        // Pass an empty array to the functions.
        // They have all the code needed to load the desired pages.
        call_user_func_array($callback, array());
    }
}

?>