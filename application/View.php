<?php
    /**
     * 
     */
    class View extends Controller {
        private $_controller;
        private $_css;
        private $_js;
        private $_libscss;
        private $_libsjs;
        private $_libscssjs;
        private $_libsjscss;
        private $_typeLibsExtension;

        private $_layoutParams;
        private $_layoutMenu;
        private $_Acl;
        /**
         * @param $request is 'application/Request.php'
         */
        public function __construct(Request $request/*, ACL $_ACL*/) {
            $this->_controller = $request->getController();
            $this->_css = array();
            $this->_js = array();
            $this->_libscssjs = array();
            $this->_libsjscss = array();
            $this->_libscss = array();
            $this->_libsjs = array();
            $this->_typeLibsExtension = -1;
            // $this->_Acl         = $_ACL;
        }

        public function index() {}        

        /**
         * @param $view
         * @param $item
         */
        public function render($view, $item = false, $error = null) {
            
            $css = array();
            if(count($this->_css)) {
                $css = $this->_css;
            }           
            $js = array();
            if(count($this->_js)) {
                $js = $this->_js;
            }
            $libscss = array();
            if(count($this->_libscss)) {
                $libscss = $this->_libscss;
            }
            $libsjs = array();
            if(count($this->_libsjs)) {
                $libsjs = $this->_libsjs;
            }
            $libscssjs = array();
            $libsjscss = array();
            $typeLibsExtension = -1;
            if(count($this->_libscssjs)) {
                    $libscssjs = $this->_libscssjs;
            }

            if(count($this->_libsjscss)) {
                    $libsjscss = $this->_libsjscss;
            }
            $_layoutParams = array(
                'root_css'  => BASE_URL . 'views/layouts/' . DEFAULT_LAYOUT . '/assets/css/',
                'root_img'  => BASE_URL . 'views/layouts/' . DEFAULT_LAYOUT . '/assets/img/',
                'root_js'   => BASE_URL . 'views/layouts/' . DEFAULT_LAYOUT . '/assets/js/',
                'libs_js'   => BASE_URL . 'libs/JS/',
                'css'       => $css,
                'js'        => $js,
                'libscss'   => $libscss,
                'libsjs'    => $libsjs,
                'libscssjs' => $libscssjs,
                'libsjscss' => $libsjscss,
                'root'      => BASE_URL
            );
            
            // $this->_Acl          = $this->_Acl;
            $this->_layoutParams = $_layoutParams;
            /**
             * 
             */
            $rootView = ROOT . 'views' . DS . $this->_controller . DS . $view . '.phtml';

            if(is_readable($rootView)) {
                include_once ROOT . 'views' . DS . 'layouts' . DS . DEFAULT_LAYOUT . DS . 'header.php';
                include_once ROOT . 'views' . DS . 'layouts' . DS . DEFAULT_LAYOUT . DS . 'menu.phtml';
                include_once $rootView;
                include_once ROOT . 'views' . DS . 'layouts' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
            } else {
                header('HTTP/1.0 404 Not Found', true, 404);
                throw new Exception('Error view');
            }
        }

        public function setCSS(array $css) {
            if(is_array($css) && count($css)) {
                for($i = 0; $i < count($css); $i++) {
                    $this->_css[] =  BASE_URL . 'views/' . $this->_controller . '/assets/css/' . $css[$i] . '.css';
                }
            } else {
                header('HTTP/1.0 404 Not Found', true, 404);
                throw new Exception('ERROR files CSS in ' . $this->_controller);
            }
        }
        public function setJS(array $js) {
            if(is_array($js) && count($js)) {
                for($i = 0; $i < count($js); $i++) {
                    $this->_js[] = BASE_URL . 'views/' . $this->_controller . '/assets/js/' . $js[$i] . '.js';
                }
            } else {
                header('HTTP/1.0 404 Not Found', true, 404);
                throw new Exception('ERROR file JS in ' . $this->_controller);
            }
        } 
        public function setLibsCSS(array $libscss) {
            if(is_array($libscss) && count($libscss)) {
                for($i = 0; $i < count($libscssjs); $i++) {
                    $this->_libscss[] = BASE_URL . 'libs/CSS/' . $libscss[$i] . '.css';
                }
            } else {
                header('HTTP/1.0 404 Not Found', true, 404);
                throw new Exception('ERROR file libs CSS in ' . $this->_controller);
            }
        }
        public function setLibsJS(array $libsjs) {
            if(is_array($libsjs) && count($libsjs)) {
                for($i = 0; $i < count($libsjs); $i++) {
                    $this->_libsjs[] = BASE_URL . 'libs/JS/' . $libsjs[$i] . '.js';
                }
            } else {
                header('HTTP/1.0 404 Not Found', true, 404);
                throw new Exception('ERROR files libs JS in ' . $this->_controller);
            }
        }
        public function setLibsCSSJS(array $libscss = [], array $libsjs = [], $location) {
            switch($location) {
                case 0:
                    
                    if(is_array($libscss) && count($libscss)) {
                        for($i = 0; $i < count($libscss); $i++) {
                                $this->_libscssjs[] = BASE_URL . 'libs/CSS&JS/' . $libscss[$i] . '.css';
                            
                        }
                    } else {
                        http_response_code(404);
                        throw new Exception('ERROR file libs CSS & JS in ' . $this->_controller);
                    }
                    break;
                case 1:
                    if(is_array($libsjs) && count($libsjs)) {
                        for($i = 0; $i < count($libsjs); $i++) {
                            $this->_libsjscss[] = BASE_URL . 'libs/CSS&JS/' . $libsjs[$i] . '.js';
                        }
                    } else {
                        http_response_code(404);
                        throw new Exception('ERROR file libs CSS & JS in ' . $this->_controller);
                    }
                    break;
                default:
                    $this->_typeLibsExtension = -1;
                    break;
            }
            
        }

        public function setLibs(array $libscss = [], array $libsjs = [], $location) {
            switch($location) {
                case 0:
                    
                    if(is_array($libscss) && count($libscss)) {
                        for($i = 0; $i < count($libscss); $i++) {
                                $this->_libscssjs[] = BASE_URL . 'libs/' . $libscss[$i] . '.css';
                            
                        }
                    } else {
                        http_response_code(404);
                        throw new Exception('ERROR file libs CSS & JS in ' . $this->_controller);
                    }
                    break;
                case 1:
                    if(is_array($libsjs) && count($libsjs)) {
                        for($i = 0; $i < count($libsjs); $i++) {
                            $this->_libsjscss[] = BASE_URL . 'libs/' . $libsjs[$i] . '.js';
                        }
                    } else {
                        http_response_code(404);
                        throw new Exception('ERROR file libs CSS & JS in ' . $this->_controller);
                    }
                    break;
                default:
                    $this->_typeLibsExtension = -1;
                    break;
            }
        }
    }
?>