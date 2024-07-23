<?php
namespace Utils;

class Logger {
    private $logFile;

    public function __construct($logFile = 'bot.log') {
        $this->logFile = $logFile;
    }

    public function log($message) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message\n";
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
}
