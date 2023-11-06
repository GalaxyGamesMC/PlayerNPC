<?php

declare(strict_types=1);

namespace issac47\PlayerNPC\entites;

use issac47\PlayerNPC\addon\Addon;
use issac47\PlayerNPC\addon\AddonManager;
use issac47\PlayerNPC\utils\NPCTrait;
use pocketmine\entity\Human as PMHuman;
use pocketmine\entity\Location;
use pocketmine\entity\Skin;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;

class Human extends PMHuman {
    use NPCTrait;

    public function __construct(Location $location, Skin $skin, ?CompoundTag $nbt = null) {
        $this->injectAddons(AddonManager::getAddons(Addon::HUMAN));
        parent::__construct($location, $skin, $nbt);
    }

    protected function initEntity(CompoundTag $nbt): void {
        parent::initEntity($nbt);
        $this->runAddons(Addon::INIT_ENTITY_EVENT, $nbt);
        $commands_tag = $nbt->getTag('commands');
        if ($commands_tag instanceof ListTag) {
            $commands = $commands_tag->getAllValues();
            $this->addCommands($commands);

        }
        $this->setNameTagAlwaysVisible();
        $this->setScale($nbt->getFloat('scale', 1));
    }

    public function saveNBT(): CompoundTag {
        return parent::saveNBT()
            ->setTag('commands', $this->exportCommands())
            ->setFloat('scale', $this->getScale());
    }

    public function onUpdate(int $currentTick): bool {
        $this->runAddons(Addon::UPDATE_EVENT, $currentTick);
        return parent::onUpdate($currentTick);
    }

    public function attack(EntityDamageEvent $source): void {
        parent::attack($source);
        $this->runAddons(Addon::ATTACK_EVENT, $source);
    }
}