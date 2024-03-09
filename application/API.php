<?php
    abstract class API {
        
        protected $_ACL;
        protected $_view;

        public function __construct() {
            $this->_ACL  = new ACL();
            $this->_view = new View(new Request, $this->_ACL);
        }
        /**
         * This abstract method forces all classes that inherit from 'Controller'
         * to implement an 'index' method, even if it has no code.
         * 
         * It will default to 'Request.php' in the method:
         * if(!$this->_method) {
         *    $this->_method = 'index';
         * }
         * 
         * And if a method is sent by mistake, it will be corrected by 'Bootstrap.php'
         */
        abstract public function index();

        /**
         * 
         */
        protected function loadModel($model) {
            $model = $model . 'Model';
            $rootModel = ROOT . 'models' . DS . $model . '.php';
            if(is_readable($rootModel)) {
                require_once $rootModel;    
                $model = new $model;
                return $model;
            } else {
                header('HTTP/1.0 404 Not Found', true, 404);
                throw new Exception('Error model');
            }
        }

        /**
         * 
         */
        protected function loadWebSocket($socket) {
            $socket = $model . 'WebSocket';
            $rootSocket = ROOT . 'web-sockets' . DS . $socket . '.php';
            if(is_readable($rootSocket)) {
                require_once $rootSocket;    
                $socket = new $socket;
                return $socket;
            } else {
                header('HTTP/1.0 404 Not Found', true, 404);
                throw new Exception('Error Web Sockets');
            }
        }

        protected function loadDTO($DTO) {
            $DTO = $DTO . '.dto';
            $rootDTO = ROOT . 'dto' . DS . $DTO . '.php';
            if(is_readable($rootDTO)) {
                require_once $rootDTO;
                    $DTO = str_replace('.dto', 'DTO', $DTO);
                $rootDTO = new $DTO;
                return $rootDTO;
            } else {
                header('HTTP/1.0 404 Not Found', true, 404);
                throw new Exception("Error $rootDTO");
            }
        }

        protected function getLibrary($folder, $library, $version, $mainFile, $extension) {
            $rootLibrary = ROOT . 'libs' . DS . $folder . DS . $library . DS . 'version/' . $version . DS . $mainFile .'.' . $extension;
            if(is_readable($rootLibrary)) {
                require_once $rootLibrary;
            } else {
                header('HTTP/1.0 404 Not Found', true, 404);
                throw new Exception('Error library ' . $rootLibrary);
            }
        }

        protected function getText($key) {
            if(isset($_POST[$key]) && !empty($_POST[$key])) {
                $_POST[$key] = htmlspecialchars($_POST[$key], ENT_QUOTES, 'UTF-8');
                return $_POST[$key];
            }
            return '';
        }

        /**
         * Request 'POST'
         */
        protected function getInt($key) {
            if(isset($_POST[$key]) && !empty($_POST[$key])) {
                $_POST[$key] = filter_input(INPUT_POST, $key, FILTER_VALIDATE_INT);
                return $_POST[$key];
            }
            return 0;
        }

        /**
         * Request 'GET'
         */
        protected function filterInt($int) {
            $int = (int) $int;
            if(is_int($int)) {
                return $int;
            } else {
                return 0;
            }
        }
        protected function filterIntEncrypted($int) {
            return $int;
        }

        protected function getPostParam($key) {
            if(isset($_POST[$key])) {
                return $_POST[$key];
            }
        }

        protected function getSQL($key) {
            if(isset($_POST[$key]) && !empty($_POST[$key])) {
                $_POST[$key] = strip_tags($_POST[$key]);

                if(!get_magic_quotes_gpc()) {
                    $_POST[$key] = mysql_escape_string($_POST[$key]);
                }

                return trim($_POST[$key]);
            }
        }

        // Escapes SQL pattern wildcards in $_POST[$key]. 
        function escape_sql_wild($key) {
            $result = array();
            foreach(str_split($_POST[$key]) as $ch)
            {
                if ($ch == "\\" || $ch == "%" || $ch == "_") {
                    $result[] = "\\";
                }
                $result[] = $ch;
            }
            return
                implode("", $result);
        }

        protected function getAlphaNum($key) {
            if(isset($_POST[$key]) && !empty($_POST[$key])) {
                $_POST[$key] = (string) preg_replace('/[^A-Z0-9_]/i', '', $_POST[$key]);
                return $_POST[$key];
            }
        }

        protected function getAlphaNumber($key) {
            if(isset($_POST[$key]) && !empty($_POST[$key])) {
                $_POST[$key] = (string) stripslashes($_POST[$key]);
                return $_POST[$key];
            }
        }

        /**
         * Validate 'email' register users
         */
        public function validateEmail($email) {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            return true;
        }

        /**
         * We detect the explorer
         */
        function detectBrowser() {
                $browser = array("IE", "OPERA", "MOZILLA", "NETSCAPE", "FIREFOX", "SAFARI", "CHROME");
                $os      = array("WIN","MAC","LINUX");

                /**
                 * We define default values for the browser and the operating system.
                 */
                $info['browser'] = "OTHER";
                $info['os']      = "OTHER";

                /**
                 * We search for the browser with its operating system
                 */
                foreach($browser as $parent) {
                    $s       = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
                    $f       = $s + strlen($parent);
                    $version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
                    $version = preg_replace('/[^0-9,.]/', '', $version);
                    if ($s) {
                        $info['browser'] = $parent;
                        $info['version'] = $version;
                    }
                }
                
                /**
                 * We get the OS
                 */
                foreach($os as $val) {
                    if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
                        $info['os'] = $val;
                }
                
                /**
                 * We return the array of values
                 */
                return $info;
        }

        /**
         *  ======================================
         * |                FILES                 |
         *  ======================================
         */
        /**
         * @ref https://stackoverflow.com/q/11716047
         */
        function encryptFile(string $inputFilename, string $outputFilename, string $key) {
            $iFP = fopen($inputFilename, 'rb');
            $oFP = fopen($outputFilename, 'wb');

            [$state, $header] = sodium_crypto_secretstream_xchacha20poly1305_init_push($key);

            fwrite($oFP, $header, 24); // Write the header first:
            $size = fstat($iFP)['size'];
            for ($pos = 0; $pos < $size; $pos += CUSTOM_CHUNK_SIZE) {
                $chunk = fread($iFP, CUSTOM_CHUNK_SIZE);
                $encrypted = sodium_crypto_secretstream_xchacha20poly1305_push($state, $chunk);
                fwrite($oFP, $encrypted, CUSTOM_CHUNK_SIZE + 17);
                sodium_memzero($chunk);
            }

            fclose($iFP);
            fclose($oFP);
            return true;
        }

        /** 
* __call magic method. 
*/
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }
    /** 
* Get URI elements. 
* 
* @return array 
*/
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode( '/', $uri );
        return $uri;
    }
    /** 
* Get querystring params. 
* 
* @return array 
*/
    protected function getQueryStringParams()
    {
        return parse_str($_SERVER['QUERY_STRING'], $query);
    }
    /** 
* Send API output. 
* 
* @param mixed $data 
* @param string $httpHeader 
*/
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        echo $data;
        exit;
    }

    }
?>