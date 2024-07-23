<?php
namespace Commands;

use Core\Bot;
use Utils\Logger;

class MenuCommand {
    private $bot;
    private $logger;

    public function __construct(Bot $bot, Logger $logger) {
        $this->bot = $bot;
        $this->logger = $logger;
    }

    public function handle($message, $chatId, $userId) {
        $this->logger->log("User $userId requested menu");

        $keyboard = [
            ['Исследование', 'Атаковать игрока'],
            ['Рейтинг игроков', 'Инвентарь'],
            ['Обмен компонентов', 'Об игре']
        ];

        $replyMarkup = [
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ];

        return [
            'text' => 'Выберите действие:',
            'reply_markup' => json_encode($replyMarkup)
        ];
    }
}
