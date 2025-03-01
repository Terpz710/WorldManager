<?php

declare(strict_types=1);

namespace terpz710\worldmanager\command\sub;

use pocketmine\Server;

use pocketmine\command\CommandSender;

use pocketmine\world\WorldCreationOptions;

use terpz710\worldmanager\utils\WorldHandler;

use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\args\IntegerArgument;
use CortexPE\Commando\args\RawStringArgument;

class CreateSubCommand extends BaseSubCommand {

    protected function prepare() : void{
        $this->registerArgument(0, new RawStringArgument("name"));
        $this->registerArgument(1, new IntegerArgument("seed", true));
        $this->registerArgument(2, new RawStringArgument("generator", true));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args) : void{
        $name = $args["name"];
        $seed = $args["seed"] ?? mt_rand();
        $generatorName = $args["generator"] ?? "normal";

        if (Server::getInstance()->getWorldManager()->isWorldGenerated($name)) {
            $sender->sendMessage("World already exists!");
            return;
        }

        $generator = WorldHandler::getInstance()->getGeneratorByName($generatorName);

        if ($generator === null) {
            $sender->sendMessage("Generator does not exist!");
            return;
        }

        Server::getInstance()->getWorldManager()->generateWorld(
            $name, 
            WorldCreationOptions::create()
                ->setSeed($seed)
                ->setGeneratorClass($generator->getGeneratorClass())
        );

        $sender->sendMessage("World generated!");
    }
}