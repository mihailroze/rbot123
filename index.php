<?php
require_once __DIR__ . '/autoload.php';

$config = require __DIR__ . '/config/config.php';

$bot = new Core\Bot($config);
$logger = new Utils\Logger(__DIR__ . '/bot.log');
$commandHandler = new Core\CommandHandler($bot, $logger);

$update = json_decode(file_get_contents('php://input'), true);

if (isset($update['message'])) {
    $chatId = $update['message']['chat']['id'];
    $message = $update['message']['text'];
    $userId = $update['message']['from']['id'];

    $response = $commandHandler->handle($message, $chatId, $userId);

    $bot->sendMessage($chatId, $response);
} else {
    $logger->log("Received update without message");
}
