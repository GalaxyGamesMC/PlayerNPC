<?php

declare(strict_types=1);

namespace issac47\PlayerNPC\utils;

use issac47\PlayerNPC\addon\Addon;
use issac47\PlayerNPC\addon\AddonBase;
use issac47\PlayerNPC\addon\types\AddonDataParameters;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\StringTag;

trait NPCTrait {

    protected array $commands = [];

    /** @var AddonBase[] */
    protected array $addons = [];

    /**
     * @return array
     */
    public function getCommands(): array {
        return $this->commands;
    }

    /**
     * @param $command
     * @return bool
     */
    public function hasCommand($command): bool {
        $key = array_search($command, $this->commands);
        return !is_bool($key);
    }

    /**
     * @param $commands
     * @return void
     */
    public function addCommands($commands): void {
        foreach ($commands as $command) {
            $this->commands[] = $command;
        }
    }

    /**
     * @param $command
     * @return void
     */
    public function removeCommand($command): void {
        unset($this->commands[array_search($command, $this->commands)]);
    }

    public function exportCommands(): ListTag {
        $commands = array_map(fn($cmd) => new StringTag($cmd), $this->commands);
        return new ListTag($commands, NBT::TAG_String);
    }

    /**
     * @param AddonBase[] $addons
     * @return void
     */
    protected function injectAddons(array $addons): void {
        foreach ($addons as $addon) {
            $this->addons[] = $addon;
        }
    }

    protected function runAddons(string $event, ...$args): void {
        $data = new AddonDataParameters($this, $args);
        foreach ($this->addons as $addon) {
            if ($event === Addon::INIT_ENTITY_EVENT) {
                $addon->onInitEntity($data);
            }
            if ($event === Addon::UPDATE_EVENT) {
                $addon->onNPCUpdate($data);
            }
            if ($event === Addon::ATTACK_EVENT) {
                $addon->onAttack($data);
            }
        }
    }
}