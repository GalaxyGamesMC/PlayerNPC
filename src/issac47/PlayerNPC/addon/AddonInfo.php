<?php

declare(strict_types=1);

namespace issac47\PlayerNPC\addon;

final class AddonInfo {

    public function __construct(
        public string $name,
        public string $author,
        public string $version,
        public string $api,
        public string $dsc = ''
    ){}
}