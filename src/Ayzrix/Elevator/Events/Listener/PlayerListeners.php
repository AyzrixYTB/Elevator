<?php

namespace Ayzrix\Elevator\Events\Listener;

use Ayzrix\Elevator\API\ElevatorAPI;
use Ayzrix\Elevator\Utils\Utils;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJumpEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\math\Vector3;

class PlayerListeners implements Listener {

    public function PlayerJump(PlayerJumpEvent $event): bool {
        $player = $event->getPlayer();
        $level = $player->getLevel();
        $block = Utils::getIntoConfig("block");
        $block = explode(":",$block);
        $id = (int)$block[0];
        $damage = (int)$block[1];

        if ($level->getBlock($player->subtract(0, 1))->getId() !== $id or $level->getBlock($player->subtract(0, 1))->getDamage() !== $damage) return false;

        $x = (int) floor($player->getX());
        $y = (int) floor($player->getY());
        $z = (int) floor($player->getZ());
        $maxY = $level->getWorldHeight();
        $found = false;
        $y++;
        for (; $y <= $maxY; $y++) {
            if ($found = (ElevatorAPI::isElevatorBlock($x, $y, $z, $level) !== null)) {
                break;
            }
        }

        if ($found) {
            if(Utils::getIntoConfig("distance") === true) {
                if ($player->distance(new Vector3($x + 0.5, $y + 1, $z + 0.5)) <= (int)Utils::getIntoConfig("max_distance")) {
                    $player->teleport(new Vector3($x + 0.5, $y + 1, $z + 0.5));
                } else $player->sendMessage(Utils::getConfigMessage("distance_too_hight"));
            } else $player->teleport(new Vector3($x + 0.5, $y + 1, $z + 0.5));
        } else $player->sendMessage(Utils::getConfigMessage("no_elevator_found"));
        return true;
    }

    public function PlayerToggleSneak(PlayerToggleSneakEvent $event): bool {
        $player = $event->getPlayer();
        $level = $player->getLevel();
        $block = Utils::getIntoConfig("block");
        $block = explode(":",$block);
        $id = (int)$block[0];
        $damage = (int)$block[1];

        if (!$event->isSneaking()) return false;
        if ($level->getBlock($player->subtract(0, 1))->getId() !== $id or $level->getBlock($player->subtract(0, 1))->getDamage() !== $damage) return false;

        $x = (int) floor($player->getX());
        $y = (int) floor($player->getY())-2;
        $z = (int) floor($player->getZ());
        $found = false;
        $y--;
        for (; $y >= 0; $y--) {
            if ($found = (ElevatorAPI::isElevatorBlock($x, $y, $z, $level) !== null)) {
                break;
            }
        }

        if ($found) {
            if(Utils::getIntoConfig("distance") === true) {
                if ($player->distance(new Vector3($x + 0.5, $y + 1, $z + 0.5)) <= (int)Utils::getIntoConfig("max_distance")) {
                    $player->teleport(new Vector3($x + 0.5, $y + 1, $z + 0.5));
                } else $player->sendMessage(Utils::getConfigMessage("distance_too_hight"));
            } else $player->teleport(new Vector3($x + 0.5, $y + 1, $z + 0.5));
        } else $player->sendMessage(Utils::getConfigMessage("no_elevator_found"));
        return true;
    }
}