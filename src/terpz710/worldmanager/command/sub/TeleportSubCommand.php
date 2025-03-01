<?php

declare(strict_types=1);

namespace terpz710\worldmanager\command\sub;

use pocketmine\Server;

use pocketmine\command\CommandSender;

use pocketmine\player\Player;

use pocketmine\world\World;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\args\RawStringArgument;

use terpz710\worldmanager\WorldManager;

class TeleportSubCommand extends BaseSubCommand {

    protected function prepare() : void{
        $this->registerArgument(0, new RawStringArgument("world"));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
        if(!$sender instanceof Player){
            $sender->sendMessage("This command can only be used in-game!");
            return;
        }

        if(!isset($args["world"])){
            $sender->sendMessage("Usage: /worldmanager teleport <world>");
            return;
        }

        $worldName = $args["world"];
        $server = Server::getInstance();

        $worldManager = $server->getWorldManager();
        $world = $worldManager->getWorldByName($worldName);

        if($world === null){
            if(!$worldManager->isWorldGenerated($worldName)){
                $sender->sendMessage("World '$worldName' does not exist");
                return;
            }

            $sender->sendMessage("Loading world '$worldName'...");
            $worldManager->loadWorld($worldName);

            $world = $worldManager->getWorldByName($worldName);
            if($world === null){
                $sender->sendMessage("Failed to load world '$worldName'");
                return;
            }
        }

        $sender->teleport($world->getSafeSpawn());
        $sender->sendMessage("§aTeleported to world: §b$worldName");
    }
}
