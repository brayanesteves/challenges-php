<?php
    class Bootstrap {
        /**
         * @param $request
         */
        public static function run(Request $request) {
            $controller     =         $request->getController() . '.controller';
            $rootController = ROOT . 'controllers' . DS . $controller . '.php';
            
            $mehod          = $request->getMethod();
            $arguments      =   $request->getArgs();
            /**
             * Test:
             * echo $rootController;
             * exit;
             */
            
             /**
              * Check if file exists
              */
            if(!is_readable($rootController)) {
                header('HTTP/1.0 404 Not Found', true, 404);
                throw new Exception('Not founds module.');                
            }
            require_once $rootController;
            $controller = str_replace('.controller', '', $controller);
            $controller = new $controller;
            if(is_callable(array($controller, $mehod))) {  
                $method = $request->getMethod();
            } else {
                $mehod = 'index';
            }

            if(isset($arguments)) {
                call_user_func_array(array($controller, $mehod), $arguments);
            } else {                    
                call_user_func(array($controller, $mehod));
            }
        }

    }
?>