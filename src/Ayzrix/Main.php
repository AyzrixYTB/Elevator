<?php

namespace Ayzrix;

use Ayzrix\Events\Listener\PlayerListeners;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    private static $instance;

    public function onEnable(){ 
    $this->saveDefaultConfig();
    self::$instance = $this;
   $this->getServer()->getPluginManager()->registerEvents(new PlayerListeners(), $this);
    }

    /**
     * @return Main
     */
    public static function getInstance(){
        return self::$instance;
    }
}
