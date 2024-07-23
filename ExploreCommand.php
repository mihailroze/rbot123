<?php
namespace Commands;

use Core\Bot;
use Utils\Logger;
use Game\Exploration;
use Game\EnergyManager;
use Game\InventoryManager;

class ExploreCommand {
    private $bot;
    private $logger;
    private $exploration;
    private $energyManager;
    private $inventoryManager;
    private $items;

    public function __construct(Bot $bot, Logger $logger) {
        $this->bot = $bot;
        $this->logger = $logger;
        $this->exploration = new Exploration();
        $this->energyManager = new EnergyManager($bot);
        $this->inventoryManager = new InventoryManager($bot);
        $this->items = require __DIR__ . '/../../config/items.php';
    }

    public function handle($message, $chatId, $userId) {
        $currentEnergy = $this->energyManager->getEnergy($userId);
        $requiredEnergy = 10;

        if ($currentEnergy < $requiredEnergy) {
            return "⚠️ <b>У вас недостаточно энергии для исследования.</b>\n\nТекущая энергия: {$currentEnergy}/{$this->energyManager->getMaxEnergy()}\nЭнергия восстанавливается со временем (1 очко в минуту).";
        }

        $this->energyManager->consumeEnergy($userId, $requiredEnergy);

        $result = $this->exploration->explore();
        $response = "<b>🔍 {$result['message']}</b>\n\n";

        if (isset($result['loot'])) {
            foreach ($result['loot'] as $item => $info) {
                $itemData = $this->items[$item];

                if ($item == 'exp') {
                    $addResult = $this->inventoryManager->addItem($userId, 'exp', $info['amount']);
                    $response .= "✨ Очки опыта: +{$addResult['added']} (всего: {$addResult['total']})\n";
                } elseif ($itemData['type'] == 'resource') {
                    $addResult = $this->inventoryManager->addItem($userId, $item, $info['amount']);
                    $response .= "📦 {$itemData['name']}: +{$addResult['added']} (всего: {$addResult['total']})\n";
                    if ($addResult['maxReached']) {
                        $response .= "⚠️ Достигнут максимум компонентов этого типа (100).\n";
                    }
                } elseif ($itemData['type'] == 'weapon') {
                    $equipResult = $this->inventoryManager->equipWeapon($userId, $item);
                    if ($equipResult['equipped']) {
                        $response .= "🔫 <b>{$equipResult['newWeapon']} было экипировано</b>\n";
                        if ($equipResult['oldWeapon']) {
                            $response .= "💰 {$equipResult['oldWeapon']} было конвертировано в {$equipResult['converted']} RustCoins\n";
                        }
                    } else {
                        $response .= "ℹ️ Найдено оружие {$itemData['name']}, но ваше текущее оружие лучше.\n";
                    }
                }
            }
        }

        $updatedEnergy = $this->energyManager->getEnergy($userId);
        $response .= "\n🔋 Оставшаяся энергия: {$updatedEnergy}/{$this->energyManager->getMaxEnergy()}";

        $this->logger->log("Player $userId explored and found loot");

        return $response;
    }
}
