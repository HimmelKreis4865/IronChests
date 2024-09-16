<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\item;

use himmelkreis4865\IronChests\block\ChestBlock;
use himmelkreis4865\IronChests\block\IronChestBlocks;
use himmelkreis4865\IronChests\item\ItemUpgradeShard;
use pocketmine\block\Block;
use RuntimeException;

class IronGoldUpgrade extends ItemUpgradeShard {

	protected function getTexture(): string {
		return "iron_gold_upgrade";
	}

	protected function getInitialChestId(): int {
		return IronChestBlocks::IRON_CHEST()->getTypeId();
	}

	protected function getOutputChest(Block $previousBlock): ChestBlock {
		if (!$previousBlock instanceof ChestBlock) {
			throw new RuntimeException("Failed to create an output chest because the previous block is different than expected");
		}
		return IronChestBlocks::GOLD_CHEST()->setFacing($previousBlock->getFacing());
	}
}