<?php
    class Model {

        protected $_db;
        public function __construct() {
            $this->_db = new Database();
        }

        public function loadDTO($DTO) {
            $DTO = $DTO . 'DTO';
            $rootDTO = ROOT . 'dto' . DS . $DTO . '.php';
            if(is_readable($rootDTO)) {
                require_once $rootDTO;    
                $rootDTO = new $rootDTO;
                return $rootDTO;
            } else {
                header('HTTP/1.0 404 Not Found', true, 404);
                throw new Exception('Error $rootDTO');
            }
        }
    }
?>