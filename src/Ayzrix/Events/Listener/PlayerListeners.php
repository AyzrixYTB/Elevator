<?php

namespace Ayzrix\Events\Listener;

use Ayzrix\API\ElevatorAPI;
use Ayzrix\Main;
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

        if ($player->getLevel()->getBlock($player->subtract(0, 1, 0))->getId() !== Main::getInstance()->getConfig()->get("Block-ID") or $player->getLevel()->getBlock($player->subtract(0, 1, 0))->getDamage() !== Main::getInstance()->getConfig()->get("Block-META")) return false;

        $level = $player->getLevel();
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
            $player->sendMessage(Main::getInstance()->getConfig()->get("Message_No_Block_Found"));
        }

        return true;
    }

    /**
     * @param PlayerToggleSneakEvent $event
     * @return bool
     */
    public function onSneak(PlayerToggleSneakEvent $event){
        $player = $event->getPlayer();

        if (!$event->isSneaking(true)) return false;

        if ($player->getLevel()->getBlock($player->subtract(0, 1, 0))->getId() !== Main::getInstance()->getConfig()->get("Block-ID") or $player->getLevel()->getBlock($player->subtract(0, 1, 0))->getDamage() !== Main::getInstance()->getConfig()->get("Block-META")) return false;

        $level = $player->getLevel();
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
            $player->sendMessage(Main::getInstance()->getConfig()->get("Message_No_Block_Found"));
        }

        return true;
    }
}