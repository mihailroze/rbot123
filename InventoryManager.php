<?php
namespace Game;

use Core\Bot;

class InventoryManager {
    private $bot;
    private $maxComponents = 100;

    public function __construct(Bot $bot) {
        $this->bot = $bot;
    }

    public function addItem($userId, $itemId, $amount) {
        $player = $this->bot->getPlayer($userId);
        if (!$player) return null;

        if (!isset($player['inventory'][$itemId])) {
            $player['inventory'][$itemId] = 0;
        }

        $items = require __DIR__ . '/../../config/items.php';
        if ($items[$itemId]['type'] == 'resource') {
            $oldAmount = $player['inventory'][$itemId];
            $newAmount = min($oldAmount + $amount, $this->maxComponents);
            $player['inventory'][$itemId] = $newAmount;
            $addedAmount = $newAmount - $oldAmount;
        } else {
            $player['inventory'][$itemId] += $amount;
            $addedAmount = $amount;
        }

        $this->bot->updatePlayer($userId, $player);

        return [
            'added' => $addedAmount,
            'total' => $player['inventory'][$itemId],
            'maxReached' => ($items[$itemId]['type'] == 'resource' && $player['inventory'][$itemId] == $this->maxComponents)
        ];
    }

    public function equipWeapon($userId, $weaponId) {
        $player = $this->bot->getPlayer($userId);
        if (!$player) return ['equipped' => false];

        $items = require __DIR__ . '/../../config/items.php';
        $newWeapon = $items[$weaponId];

        if (isset($player['weapon'])) {
            $oldWeaponId = $player['weapon']['id'];
            $oldWeapon = $items[$oldWeaponId];

            if ($newWeapon['damage'] > $oldWeapon['damage']) {
                // Convert old weapon to RustCoins
                $rustcoins = $oldWeapon['damage'] * 10; // Example conversion rate
                $player['rustcoin'] += $rustcoins;

                // Equip new weapon
                $player['weapon'] = [
                    'id' => $weaponId,
                    'durability' => $newWeapon['durability']
                ];

                $this->bot->updatePlayer($userId, $player);

                return [
                    'equipped' => true,
                    'converted' => $rustcoins,
                    'oldWeapon' => $oldWeapon['name'],
                    'newWeapon' => $newWeapon['name']
                ];
            } else {
                // Convert new weapon to RustCoins if it's weaker
                $rustcoins = $newWeapon['damage'] * 10;
                $player['rustcoin'] += $rustcoins;
                $this->bot->updatePlayer($userId, $player);

                return [
                    'equipped' => false,
                    'converted' => $rustcoins,
                    'oldWeapon' => $oldWeapon['name'],
                    'newWeapon' => $newWeapon['name']
                ];
            }
        } else {
            // If no weapon equipped, equip the new one
            $player['weapon'] = [
                'id' => $weaponId,
                'durability' => $newWeapon['durability']
            ];
            $this->bot->updatePlayer($userId, $player);

            return [
                'equipped' => true,
                'converted' => 0,
                'oldWeapon' => null,
                'newWeapon' => $newWeapon['name']
            ];
        }
    }
}
