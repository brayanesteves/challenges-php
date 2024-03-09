<?php
    class index extends Controller {
        public function __construct() {
            parent::__construct();
        }

        public function index() {            
            $this->_view->setCSS(array('styles'));
            // Load Second
            $this->_view->setJS(array('main'));
            $this->_view->title = 'Home';
            $this->_view->render('index', 'index');
        }
        
    }
?>