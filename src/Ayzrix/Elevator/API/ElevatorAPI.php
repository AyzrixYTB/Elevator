<?php

namespace Ayzrix\Elevator\API;

use Ayzrix\Elevator\Main;
use pocketmine\block\Block;
use pocketmine\level\Level;

class ElevatorAPI {


    /**
     * @param int $x
     * @param int $y
     * @param int $z
     * @param Level $level
     * @return Block|null
     */
    public static function isElevatorBlock(int $x, int $y, int $z, Level $level) {
        $elevator = $level->getBlockAt($x, $y, $z);
        $config = Main::getInstance()->getConfig();

        if ($elevator->getId() !== $config->get("Block-ID") or $elevator->getDamage() !== $config->get("Block-META")) {
            return null;
        }

        return $elevator;
    }
}