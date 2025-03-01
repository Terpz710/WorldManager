<?php

declare(strict_types=1);

namespace terpz710\worldmanager\command;

use pocketmine\command\CommandSender;

use terpz710\worldmanager\command\sub\CreateSubCommand;
use terpz710\worldmanager\command\sub\TeleportSubCommand;

use CortexPE\Commando\BaseCommand;

class WorldCommand extends BaseCommand {

    protected function prepare() : void{
        $this->setPermission("worldmanager.cmd");

        $this->registerSubCommand(new CreateSubCommand("create", "Generate a new world", ["new", "c"]));
        $this->registerSubCommand(new TeleportSubCommand("teleport", "Teleport to a different world", ["tp"]));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
        $sender->sendMessage("----WorldManager Commands----");
        $sender->sendMessage("/worldmanager create <name> <seed> <generator>");
    }
}
