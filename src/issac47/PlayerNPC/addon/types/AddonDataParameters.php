<?php

declare(strict_types=1);

namespace issac47\PlayerNPC\addon\types;

use pocketmine\entity\Entity;

final class AddonDataParameters {

    protected array $args;

    public function __construct(
        private readonly Entity $entity,
        ...$args
    ) {
        $this->args = $args;
    }

    public function getEntity(): Entity {
        return $this->entity;
    }

    public function getArgs(): array {
        return $this->args;
    }
}