<?php
    class documents extends Controller {
        private $_contentType;
        private $_contentDisposition;
        private $_name;
        private $_extension;
        private $_quantity;

        public function __construct() {
            parent::__construct();
            $this->_quantity = 10000;
        }

        public function index() {            
            $this->_view->setCSS(array('styles'));
            // Load Second
            $this->_view->setJS(array('main'));
            $this->_view->title = 'Documents';
            $this->_view->render('index', 'documents');
        }
        

        public function fetchingWrite() {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            header("Access-Control-Allow-Methods: POST");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            $data = json_decode(file_get_contents("php://input"));
            
            $segment   = explode(".", $data->nameFiles);
            $name      = $segment[0];
            $extension = $segment[1];

            $this->_contentType        = $data->contentType;
            $this->_contentDisposition = $data->contentDisposition;
            $this->_name               = $name;
            $this->_extension          = $extension;
            $this->_quantity           = $data->quantity;
            // Generar la URL de descarga del archivo
            $downloadUrl = "http://localhost:8083/challenges-php/documents/downloadcsv";

            http_response_code(201); 
            echo json_encode(array("status" => 201, "message" => "File '{$data->nameFiles}' created successfully.", "DownloadLink" => $downloadUrl));
        }

        public function createDataSimulateTest() {
            header("Content-Type: {$this->_contentType}");
            header("Content-Disposition: {$this->_contentDisposition}; filename='{$this->_name}.{$this->_extension}'");
    
            // Generar contenido simulado para el archivo CSV
            $content = "";
            for ($i = 0; $i < $this->_quantity; $i++) {
                $int = mt_rand(1262055681, 1262055681);
                $date = date("Y-m-d", $int);
                $time = date("H:i:s", $int);
                // Agregar datos simulados al contenido
                $content .= "{$i},{$this->ipsum(1)},{$date},{$time}\n";
            }
    
            return $content;
        }

        public function download() {
            
            $this->_view->render('download', 'documents');
    
        }

        public function downloadcsv() {
            header("Content-Type: text/plain");
            header('Content-Disposition: attachement; filename="' . 'FileCSVTest_' . date('Y-m-dH:i:s') . '.csv"');
            
            for($i = 0; $i < $this->_quantity; $i++) {
                $int  = mt_rand(1262055681, 1262055681);
                $date = date("Y-m-d", $int);
                $time = date("H:i:s", $int);
                // Agregar datos simulados al contenido
                echo "{$i},{$this->ipsum(1)},{$date},{$time}\n";
            }
    
        }
    }
?>