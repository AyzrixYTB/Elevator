<?php

namespace Ayzrix\Elevator;

use Ayzrix\Elevator\Events\Listener\PlayerListeners;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    /** @var Main $instance */
    private static $instance;

    public function onEnable() {
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new PlayerListeners(), $this);
    }

    /**
     * @return Main
     */
    public static function getInstance(): Main {
        return self::$instance;
    }
}
