<?php

declare(strict_types=1);

namespace issac47\PlayerNPC\addon;

use issac47\PlayerNPC\addon\types\AddonDataParameters;
use issac47\PlayerNPC\VersionInfo;
use pocketmine\Server;
use pocketmine\thread\log\AttachableThreadSafeLogger;

abstract class AddonBase {

    public function __construct() {
        $current_api = VersionInfo::API;
        $addon_api = $this->getInfo()->api;
        if (version_compare($current_api, $addon_api, '!=')) {
            throw new \LogicException("Addon {$this->getInfo()->name} does not have the same API ({$addon_api}) compared to the current ({$current_api})!");
        }
        $this->onLoad();
    }

    abstract public function getInfo(): AddonInfo;

    abstract public function getAddonType(): int;

    protected function onLoad(): void {}

    abstract public function onInitEntity(AddonDataParameters $args): void;

    abstract public function onNPCUpdate(AddonDataParameters $args): void;

    abstract public function onAttack(AddonDataParameters $args): void;

    public function getName(): string {
        return $this->getInfo()->name;
    }

    public function getDescription(): string {
        return $this->getInfo()->dsc;
    }

    public function getLogger(): AttachableThreadSafeLogger {
        return Server::getInstance()->getLogger();
    }
}