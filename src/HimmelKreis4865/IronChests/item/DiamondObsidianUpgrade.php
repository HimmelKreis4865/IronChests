<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\item;

use HimmelKreis4865\IronChests\block\ChestBlock;
use HimmelKreis4865\IronChests\block\IronChestBlocks;
use HimmelKreis4865\IronChests\item\ItemUpgradeShard;

class DiamondObsidianUpgrade extends ItemUpgradeShard {

	protected function getTexture(): string {
		return "diamond_obsidian_upgrade";
	}

	protected function getInitialChestId(): int {
		return IronChestBlocks::DIAMOND_CHEST()->getTypeId();
	}

	protected function getOutputChest(ChestBlock $previousBlock): ChestBlock {
		return IronChestBlocks::CRYSTAL_CHEST()->setFacing($previousBlock->getFacing());
	}
}