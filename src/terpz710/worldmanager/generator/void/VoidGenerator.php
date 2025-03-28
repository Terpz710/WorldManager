<?php

declare(strict_types=1);

namespace terpz710\worldmanager\generator\void;

use pocketmine\world\ChunkManager;
use pocketmine\world\generator\Generator;

use pocketmine\block\VanillaBlocks;

class VoidGenerator extends Generator {

    public function __construct(int $seed, string $preset) {
        parent::__construct($seed, $preset);
    }

    public function generateChunk(ChunkManager $world, int $chunkX, int $chunkZ) : void{
        $chunk = $world->getChunk($chunkX, $chunkZ);

        if ($chunkX === 16 && $chunkZ === 16) {
            $chunk->setBlockStateId(0, 64, 0, VanillaBlocks::GRASS()->getStateId());
        }
    }

    public function populateChunk(ChunkManager $world, int $chunkX, int $chunkZ) : void{
    }
}
