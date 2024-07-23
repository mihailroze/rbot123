<?php
namespace Commands;

use Core\Bot;
use Utils\Logger;

class HelpCommand {
    private $bot;
    private $logger;

    public function __construct(Bot $bot, Logger $logger) {
        $this->bot = $bot;
        $this->logger = $logger;
    }

    public function handle($message, $chatId, $userId) {
        $this->logger->log("User $userId requested help");
        return "Доступные команды:\n/start - Начать игру\n/help - Показать это сообщение";
    }
}
