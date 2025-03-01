<?php

declare(strict_types=1);

namespace terpz710\worldmanager\utils;

use pocketmine\utils\SingletonTrait;

use pocketmine\world\generator\GeneratorManager;
use pocketmine\world\generator\GeneratorManagerEntry;

final class WorldHandler {
    use SingletonTrait;

    public function getGeneratorByName(string $name) : ?GeneratorManagerEntry{
        $name = match(strtolower($name)) {
            "normal", "classic", "basic", "vanilla" => "vanilla_normal",
            "nether", "hell" => "vanilla_nether",
            "ender" => "end",
            "superflat", "flat" => "flat",
            "nether_old" => "nether",
            "normal_old" => "normal",
            "void", "empty", "emptyworld" => "void",
            default => strtolower($name)
        };
	     return GeneratorManager::getInstance()->getGenerator($name);
    }
}