<?php

namespace Ayzrix\Elevator\Events\Listener;

use Ayzrix\Elevator\API\ElevatorAPI;
use Ayzrix\Elevator\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJumpEvent;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\math\Vector3;

class PlayerListeners implements Listener
{

    /**
     * @param PlayerJumpEvent $event
     * @return bool
     */
    public function onJump(PlayerJumpEvent $event){
        $player = $event->getPlayer();
        $level = $player->getLevel();
        $config = Main::getInstance()->getConfig();

        if ($level->getBlock($player->subtract(0, 1, 0))->getId() !== $config->get("Block-ID") or $level->getBlock($player->subtract(0, 1, 0))->getDamage() !== $config->get("Block-META")) return false;

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
            $player->teleport(new Vector3($x+0.5, $y+1, $z+0.5));
        } else {
            $player->sendMessage($config->get("Message_No_Block_Found"));
        }

        return true;
    }

    /**
     * @param PlayerToggleSneakEvent $event
     * @return bool
     */
    public function onSneak(PlayerToggleSneakEvent $event){
        $player = $event->getPlayer();
        $level = $player->getLevel();
        $config = Main::getInstance()->getConfig();

        if (!$event->isSneaking()) return false;

        if ($level->getBlock($player->subtract(0, 1, 0))->getId() !== $config->get("Block-ID") or $level->getBlock($player->subtract(0, 1, 0))->getDamage() !== $config->get("Block-META")) return false;


        $x = (int) floor($player->getX());
        $y = (int) floor($player->getY())-2;
        $z = (int) floor($player->getZ());
        $found = false;
        $y--;
        for (; $y >= 0; $y--) {
            if ($found = (ElevatorAPI::isElevatorBlock($x, $y, $z, $level) !== null)){
                break;
            }
        }

        if ($found) {
            $player->teleport(new Vector3($x+0.5, $y+1, $z+0.5));
        } else {
            $player->sendMessage($config->get("Message_No_Block_Found"));
        }

        return true;
    }
}