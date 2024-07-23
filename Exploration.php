<?php
namespace Game;

class Exploration {
    private $items;
    private $containers;

    public function __construct() {
        $this->items = require __DIR__ . '/../../config/items.php';
        $this->containers = require __DIR__ . '/../../config/containers.php';
    }

    public function explore() {
        $container = $this->selectContainer();
        if (!$container) {
            return ['message' => 'Вы ничего не нашли в этот раз.'];
        }

        $loot = $this->generateLoot($container);
        return [
            'message' => "Вы нашли {$container['name']}!",
            'loot' => $loot
        ];
    }

    private function selectContainer() {
        $rand = mt_rand(1, 100);
        $cumulativeChance = 0;

        foreach ($this->containers as $container) {
            $cumulativeChance += $container['chance'];
            if ($rand <= $cumulativeChance) {
                return $container;
            }
        }

        return null;
    }

    private function generateLoot($container) {
        $loot = [];
        $lootItem = array_rand($container['loot']);
        $lootInfo = $container['loot'][$lootItem];
        $amount = mt_rand($lootInfo['min'], $lootInfo['max']);

        $loot[$lootItem] = [
            'name' => $this->items[$lootItem]['name'],
            'amount' => $amount
        ];

        return $loot;
    }
}
