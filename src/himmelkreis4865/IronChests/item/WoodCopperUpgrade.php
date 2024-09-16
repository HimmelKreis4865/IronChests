<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\item;

use himmelkreis4865\IronChests\block\ChestBlock;
use himmelkreis4865\IronChests\block\IronChestBlocks;
use himmelkreis4865\IronChests\item\ItemUpgradeShard;
use pocketmine\block\Block;
use pocketmine\block\Chest;
use pocketmine\block\VanillaBlocks;
use pocketmine\math\Facing;
use RuntimeException;

class WoodCopperUpgrade extends ItemUpgradeShard {

	protected function getTexture(): string {
		return "wood_copper_upgrade";
	}

	protected function getInitialChestId(): int {
		return VanillaBlocks::CHEST()->getTypeId();
	}

	protected function getOutputChest(Block $previousBlock): ChestBlock {
		if (!$previousBlock instanceof Chest) {
			throw new RuntimeException("Failed to create an output chest because the previous block is different than expected");
		}
		return IronChestBlocks::COPPER_CHEST()->setFacing(Facing::opposite($previousBlock->getFacing()));
	}
}