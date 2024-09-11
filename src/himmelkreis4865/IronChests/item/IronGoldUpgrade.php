<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\item;

use himmelkreis4865\IronChests\block\ChestBlock;
use himmelkreis4865\IronChests\block\IronChestBlocks;
use himmelkreis4865\IronChests\item\ItemUpgradeShard;

class IronGoldUpgrade extends ItemUpgradeShard {

	protected function getTexture(): string {
		return "iron_gold_upgrade";
	}

	protected function getInitialChestId(): int {
		return IronChestBlocks::IRON_CHEST()->getTypeId();
	}

	protected function getOutputChest(ChestBlock $previousBlock): ChestBlock {
		return IronChestBlocks::GOLD_CHEST()->setFacing($previousBlock->getFacing());
	}
}