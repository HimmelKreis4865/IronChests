<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\item;

use himmelkreis4865\IronChests\block\ChestBlock;
use himmelkreis4865\IronChests\block\IronChestBlocks;
use himmelkreis4865\IronChests\item\ItemUpgradeShard;
use pocketmine\block\Block;
use pocketmine\block\Chest;
use RuntimeException;

class CopperIronUpgrade extends ItemUpgradeShard {

	protected function getTexture(): string {
		return "copper_iron_upgrade";
	}

	protected function getInitialChestId(): int {
		return IronChestBlocks::COPPER_CHEST()->getTypeId();
	}

	protected function getOutputChest(Block $previousBlock): ChestBlock {
		if (!$previousBlock instanceof ChestBlock) {
			throw new RuntimeException("Failed to create an output chest because the previous block is different than expected");
		}
		return IronChestBlocks::IRON_CHEST()->setFacing($previousBlock->getFacing());
	}
}