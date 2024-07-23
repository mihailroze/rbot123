<?php
namespace Commands;

use Core\Bot;
use Utils\Logger;
use Game\EnergyManager;

class StatusCommand {
    private $bot;
    private $logger;
    private $energyManager;

    public function __construct(Bot $bot, Logger $logger) {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->energyManager = new EnergyManager($bot);
    }

    public function handle($message, $chatId, $userId) {
        $players = $this->bot->loadPlayers();
        $player = $players[$userId];

        $currentEnergy = $this->energyManager->getEnergy($userId);

        $response = "<b>📊 Статус игрока</b>\n\n";
        $response .= "👤 Имя: {$player['name']}\n";
        $response .= "✨ Опыт: {$player['exp']}\n";
        $response .= "🔋 Энергия: {$currentEnergy}/{$this->energyManager->getMaxEnergy()}\n";
        $response .= "💰 RustCoins: " . ($player['inventory']['rustcoin'] ?? 0) . "\n";

        $response .= "\n<b>📦 Инвентарь:</b>\n";
        if (empty($player['inventory'])) {
            $response .= "Ваш инвентарь пуст.\n";
        } else {
            foreach ($player['inventory'] as $item => $amount) {
                if ($item != 'rustcoin') {
                    $itemData = $this->getItemData($item);
                    $response .= "{$itemData['name']}: {$amount}\n";
                }
            }
        }

        if (isset($player['equipped_weapon'])) {
            $weaponId = $player['equipped_weapon']['id'];
            $weapon = $this->getItemData($weaponId);
            $response .= "\n🔫 <b>Экипированное оружие:</b>\n";
            $response .= "  {$weapon['name']}\n";
            $response .= "  - Урон: {$weapon['damage']}\n";
            $response .= "  - Прочность: {$player['equipped_weapon']['durability']}/{$weapon['durability']}\n";
        }

        $this->logger->log("Player $userId checked status");

        return $response;
    }

    private function getItemData($itemId) {
        $items = require __DIR__ . '/../../config/items.php';
        return $items[$itemId] ?? ['name' => 'Неизвестный предмет'];
    }
}
