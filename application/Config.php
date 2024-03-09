<?php  
    /**
     * It is to include files from the 'views' side
     * 'User side'
     */
    define('BASE_ENVIROMENTS', 'LOCAL');
    define('BASE_URL', 'http://localhost:8083/challenges-php/');
    define('BASE_URL_LOCAL', 'http://localhost:8083/challenges-php/');
    define('BASE_URL_DEV', '');
    define('BASE_URL_TESTING', '');
    define('BASE_URL_PRODUCTION', '');
    /**
     * This constant will mean the default controller of the application
     * In case no controller is sent in the URL, it will request the 'index' controller
     * And if we want to change a default value, we change the 'index' values
     */
    define('DEFAULT_CONTROLLER', 'index');

    /**
     * Is folder 'layout' directory 'views'
     */
    define('DEFAULT_LAYOUT', 'default');

    /**
     * ===========================
     * ===========================
     */
    define('APP_NAME', 'Halcón Bit');
    define('APP_SLOGAN', 'Наука — это весело, наслаждайся ею.');
    define('APP_COMPANY', 'Halcón Bit');

    define('SESSION_TIME', 10);

    /**
     * 
     */
    define('HASH_KEY', '4f6a6d832be79');
    define('CUSTOM_CHUNK_SIZE', 8192);

    /**
     *  ===========================
     * |          DATABASE         |
     *  ===========================
     */
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '1234');
    define('DB_NAME', 'MIPSS_');
    define('DB_CHAR', 'utf8');
?>