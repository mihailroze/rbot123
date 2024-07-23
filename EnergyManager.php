<?php
namespace Game;

use Core\Bot;

class EnergyManager {
    private $bot;
    private $maxEnergy = 100;
    private $energyPerMinute = 1;

    public function __construct(Bot $bot) {
        $this->bot = $bot;
    }

    public function getEnergy($userId) {
        $player = $this->bot->getPlayer($userId);
        if (!$player) return 0;

        $currentTime = time();
        $lastUpdateTime = $player['last_loot'] ?? $currentTime;
        $timeDiff = $currentTime - $lastUpdateTime;
        $energyGain = min(floor($timeDiff / 60) * $this->energyPerMinute, $this->maxEnergy - $player['energy']);

        $player['energy'] = min($player['energy'] + $energyGain, $this->maxEnergy);
        $player['last_loot'] = $currentTime;

        $this->bot->updatePlayer($userId, $player);

        return $player['energy'];
    }

    public function consumeEnergy($userId, $amount) {
        $player = $this->bot->getPlayer($userId);
        if (!$player || $player['energy'] < $amount) {
            return false;
        }

        $player['energy'] -= $amount;
        $this->bot->updatePlayer($userId, $player);

        return $player['energy'];
    }

    public function getMaxEnergy() {
        return $this->maxEnergy;
    }
}
