<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\item;

use himmelkreis4865\IronChests\block\ChestBlock;
use himmelkreis4865\IronChests\block\IronChestBlocks;
use himmelkreis4865\IronChests\item\ItemUpgradeShard;

class GoldDiamondUpgrade extends ItemUpgradeShard {

	protected function getTexture(): string {
		return "gold_diamond_upgrade";
	}

	protected function getInitialChestId(): int {
		return IronChestBlocks::GOLD_CHEST()->getTypeId();
	}

	protected function getOutputChest(ChestBlock $previousBlock): ChestBlock {
		return IronChestBlocks::DIAMOND_CHEST()->setFacing($previousBlock->getFacing());
	}
}