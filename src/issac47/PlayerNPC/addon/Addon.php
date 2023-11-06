<?php

declare(strict_types=1);

namespace issac47\PlayerNPC\addon;

enum Addon: int {

    public const ALL = 0;
    public const HUMAN = 1;
    public const ENTITY = 2;

    public const INIT_ENTITY_EVENT = 'onInitEntityEvent';
    public const UPDATE_EVENT = 'onUpdateEvent';
    public const ATTACK_EVENT = 'onAttackEvent';
}