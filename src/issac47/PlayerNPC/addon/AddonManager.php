<?php

declare(strict_types=1);

namespace issac47\PlayerNPC\addon;

final class AddonManager {

    protected static array $addons = [];

    public static function loadAddon(AddonBase $addon): void {
        self::$addons[] = $addon;
    }

    public static function getAddons($type = Addon::ALL): array {
        return array_filter(self::$addons, fn ($value) => $value === $type || $value === Addon::ALL);
    }
}