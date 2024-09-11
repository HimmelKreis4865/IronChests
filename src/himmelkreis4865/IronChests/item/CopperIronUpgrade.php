<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\item;

use himmelkreis4865\IronChests\block\ChestBlock;
use himmelkreis4865\IronChests\block\IronChestBlocks;
use himmelkreis4865\IronChests\item\ItemUpgradeShard;

class CopperIronUpgrade extends ItemUpgradeShard {

	protected function getTexture(): string {
		return "copper_iron_upgrade";
	}

	protected function getInitialChestId(): int {
		return IronChestBlocks::COPPER_CHEST()->getTypeId();
	}

	protected function getOutputChest(ChestBlock $previousBlock): ChestBlock {
		return IronChestBlocks::IRON_CHEST()->setFacing($previousBlock->getFacing());
	}
}