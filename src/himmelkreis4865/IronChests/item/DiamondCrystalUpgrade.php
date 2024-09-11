<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\item;

use himmelkreis4865\IronChests\block\ChestBlock;
use himmelkreis4865\IronChests\block\IronChestBlocks;
use himmelkreis4865\IronChests\item\ItemUpgradeShard;

class DiamondCrystalUpgrade extends ItemUpgradeShard {

	protected function getTexture(): string {
		return "diamond_crystal_upgrade";
	}

	protected function getInitialChestId(): int {
		return IronChestBlocks::DIAMOND_CHEST()->getTypeId();
	}

	protected function getOutputChest(ChestBlock $previousBlock): ChestBlock {
		return IronChestBlocks::CRYSTAL_CHEST()->setFacing($previousBlock->getFacing());
	}
}