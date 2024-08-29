<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\item;

use HimmelKreis4865\IronChests\block\ChestBlock;
use HimmelKreis4865\IronChests\block\IronChestBlocks;
use HimmelKreis4865\IronChests\item\ItemUpgradeShard;
use pocketmine\block\VanillaBlocks;

class WoodCopperUpgrade extends ItemUpgradeShard {

	protected function getTexture(): string {
		return "wood_copper_upgrade";
	}

	protected function getInitialChestId(): int {
		return VanillaBlocks::CHEST()->getTypeId();
	}

	protected function getOutputChest(ChestBlock $previousBlock): ChestBlock {
		return IronChestBlocks::COPPER_CHEST()->setFacing($previousBlock->getFacing());
	}
}