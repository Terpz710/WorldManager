<?php

declare(strict_types=1);

namespace terpz710\worldmanager;

use pocketmine\plugin\PluginBase;

use pocketmine\world\generator\GeneratorManager;

use terpz710\worldmanager\command\WorldCommand;

use terpz710\worldmanager\generator\end\EndGenerator;
use terpz710\worldmanager\generator\void\VoidGenerator;

use CortexPE\Commando\PacketHooker;

use muqsit\vanillagenerator\generator\nether\NetherGenerator;
use muqsit\vanillagenerator\generator\overworld\OverworldGenerator;

final class WorldManager extends PluginBase {

    protected static self $instance;

    protected function onLoad(): void {
        self::$instance = $this;
    }

    public function onEnable(): void {
        if (!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }

        $this->getServer()->getCommandMap()->register(
            "WorldManager", 
            new WorldCommand($this, "worldmanager", "Create|Delete|Load|Unload worlds", ["wm"])
        );

        $generators = [
            "end" => EndGenerator::class,
            "void" => VoidGenerator::class,
            "vanilla_normal" => OverworldGenerator::class,
            "vanilla_nether" => NetherGenerator::class
        ];

        foreach ($generators as $name => $class) {
            GeneratorManager::getInstance()->addGenerator($class, $name, fn() => null, true);
        }
    }

    public static function getInstance(): self {
        return self::$instance;
    }
}
