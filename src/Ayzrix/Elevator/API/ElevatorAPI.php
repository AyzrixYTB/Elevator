<?php

namespace Ayzrix\Elevator\API;

use Ayzrix\Elevator\Utils\Utils;
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
    public static function isElevatorBlock(int $x, int $y, int $z, Level $level): ?Block {
        $elevator = $level->getBlockAt($x, $y, $z);
        $block = Utils::getIntoConfig("block");
        $block = explode(":",$block);
        $id = (int)$block[0];
        $damage = (int)$block[1];

        if ($elevator->getId() !== $id or $elevator->getDamage() !== $damage) {
            return null;
        }

        return $elevator;
    }
}