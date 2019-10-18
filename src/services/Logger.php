<?php

class Logger
{
    const INFO = 'info';
    const ERROR = 'error';

    private $errorFilePath;
    private $infoFilePath; 

    private static $loggerInstance;

    private function __construct()
    {
        include_once __DIR__ . '/../config/config.php';        
        $this->errorFilePath = $ERROR_LOG_FILE;
        $this->infoFilePath = $INFO_LOG_FILE;
    }

    private static function getInstance()
    {
        if(!self::$loggerInstance)
        {
            self::$loggerInstance = new Logger();
        }
        return self::$loggerInstance;
    }

    private function writeToFile($message, $level)
    {
        $filepath;
        switch($level){
            case 'error':
                $filepath= $this->errorFilePath;
            default: 
                $filepath= $this->infoFilePath;
        }
        $filepath = $_SERVER['DOCUMENT_ROOT'] . $filepath;
        $dirname = dirname($filepath);
        if (!is_dir($dirname)) { mkdir($dirname, 0755, true); }
        $fd = fopen($filepath, "a");
        fwrite($fd, $message . "\n");
        fclose($fd);
    }

    public static function log($message, $level = Logger::INFO)
    {
        $filepath;
        $date = date('Y-m-d H:i:s');
        $message = "$date ::$message";
        self::getInstance()->writeToFile($message, $level);
    }
}

?>
