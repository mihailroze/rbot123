<?php
namespace Core;

use Commands\HelpCommand;
use Commands\MenuCommand;
use Commands\ExploreCommand;
use Commands\StatusCommand;
use Utils\Logger;

class CommandHandler {
    private $bot;
    private $logger;
    private $commands;

    public function __construct(Bot $bot, Logger $logger) {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->commands = [
            '/help' => new HelpCommand($bot, $logger),
            '/menu' => new MenuCommand($bot, $logger),
            'Исследование' => new ExploreCommand($bot, $logger),
            'Инвентарь' => new StatusCommand($bot, $logger)
        ];
    }

    public function handle($message, $chatId, $userId) {
        $command = trim($message);
        $player = $this->bot->getPlayer($userId);

        if ($command === '/start') {
            return $this->handleStart($chatId, $userId);
        }

        if (!$player || empty($player['name'])) {
            return $this->handleRegistration($command, $chatId, $userId);
        }

        if (isset($this->commands[$command])) {
            return $this->commands[$command]->handle($message, $chatId, $userId);
        } else {
            return "Извините, я не понимаю эту команду. Используйте /help для списка доступных команд или /menu для вызова меню.";
        }
    }

    private function handleStart($chatId, $userId) {
        $player = $this->bot->getPlayer($userId);
        if ($player && !empty($player['name'])) {
            return "Вы уже зарегистрированы, {$player['name']}! Используйте /help для списка команд.";
        }
        $this->logger->log("Player started registration: $userId");
        return "Добро пожаловать! Пожалуйста, введите ваш никнейм.";
    }

    private function handleRegistration($name, $chatId, $userId) {
        $player = $this->bot->getPlayer($userId) ?? [
            'id' => $userId,
            'name' => '',
            'health' => 100,
            'points' => 0,
            'energy' => 100,
            'weapon' => null,
            'rustcoin' => 0,
            'last_loot' => null,
            'inventory' => [],
            'wins' => 0,
            'losses' => 0
        ];

        $player['name'] = $name;
        $this->bot->updatePlayer($userId, $player);
        $this->logger->log("Player completed registration: $userId, Name: $name");
        return "Спасибо, {$name}! Вы успешно зарегистрированы. Используйте /help для списка команд или /menu для вызова меню.";
    }
}
