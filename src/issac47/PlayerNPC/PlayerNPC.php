<?php

declare(strict_types=1);

namespace issac47\PlayerNPC;

use issac47\PlayerNPC\addon\AddonBase;
use issac47\PlayerNPC\addon\AddonManager;
use pocketmine\plugin\PluginBase;

class PlayerNPC extends PluginBase {

    protected function onEnable(): void {
        @mkdir($this->getDataFolder() . "addons");
        $this->loadAddons();
    }

    protected function loadAddons(): void {
        $addons = scandir($this->getDataFolder() . "addons");
        $namespace = "issac47\\PlayerNPC\\";
        $loaded = [];
        foreach ($addons as $addon) {
            $className = explode(".php", $addon)[0];
            if($className !== "." && $className !== ".."){
                require_once $this->getDataFolder() . "addons/$className.php";
                $class = $namespace . $className;
                $addonCall = new $class();
                if ($addonCall instanceof AddonBase) {
                    AddonManager::loadAddon($addonCall);
                    $loaded[] = $className . " v" . $addonCall->getInfo()->version;
                }
            }
        }
        $this->getLogger()->info("Loaded " . sizeof($loaded) . " addons includes: " . implode(', ', $loaded));
    }
}