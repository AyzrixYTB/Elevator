<?php

namespace Ayzrix\Elevator\Utils;

use Ayzrix\Elevator\Main;

class Utils {

    /**
     * @return string
     */
    public static function getPrefix(): string {
        $config = Main::getInstance()->getConfig();
        return $config->get("prefix");
    }

    public static function getConfigMessage(string $text, array $args = array()): string {
        $config = Main::getInstance()->getConfig();
        $message = $config->get($text);
        if (!empty($args)) {
            foreach ($args as $arg) {
                $message = preg_replace("/[%]/", $arg, $message, 1);
            }
        }
        return str_replace('{prefix}', self::getPrefix(), $message);
    }

    /**
     * @param string $value
     * @return bool|string|int
     */
    public static function getIntoConfig(string $value) {
        $config = Main::getInstance()->getConfig();
        return $config->get($value);
    }
}