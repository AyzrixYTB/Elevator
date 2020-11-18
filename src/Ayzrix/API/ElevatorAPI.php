<?php

namespace Ayzrix\API;

use Ayzrix\Main;
use pocketmine\block\Block;
use pocketmine\level\Level;

class ElevatorAPI {


    /**
     * @param int $x
     * @param int $y
     * @param int $z
     * @param Level $level
     * @return Block
     */
    public static function isElevatorBlock(int $x, int $y, int $z, Level $level) {
        $elevator = $level->getBlockAt($x, $y, $z);

        if ($elevator->getId() !== Main::getInstance()->getConfig()->get("Block-ID") or $elevator->getDamage() !== Main::getInstance()->getConfig()->get("Block-META")) {
            return null;
        }

        return $elevator;
    }
}