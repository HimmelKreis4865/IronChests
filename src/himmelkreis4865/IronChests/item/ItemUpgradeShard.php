<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\item;

use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\ItemComponents;
use customiesdevs\customies\item\ItemComponentsTrait;
use himmelkreis4865\IronChests\block\ChestBlock;
use himmelkreis4865\IronChests\block\tile\ChestTile;
use himmelkreis4865\IronChests\event\ChestUpgradeEvent;
use pocketmine\block\Block;
use pocketmine\block\tile\Container;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

abstract class ItemUpgradeShard extends Item  implements ItemComponents {
	use ItemComponentsTrait;

	public function __construct(ItemIdentifier $identifier, string $name = "Unknown", array $enchantmentTags = []) {
		parent::__construct($identifier, $name, $enchantmentTags);
		$this->initComponent($this->getTexture(), new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_ITEMS));
	}

	public function getMaxStackSize(): int {
		return 1;
	}

	abstract protected function getTexture(): string;

	abstract protected function getInitialChestId(): int;

	abstract protected function getOutputChest(Block $previousBlock): ChestBlock;

	public function onInteractBlock(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, array &$returnedItems): ItemUseResult {
		if ($blockClicked->getTypeId() !== $this->getInitialChestId()) {
			return ItemUseResult::FAIL;
		}
		$world = $player->getWorld();
		$tile = $world->getTile($blockClicked->getPosition());
		if ($tile instanceof Container) {
			$output = $this->getOutputChest($blockClicked);
			$event = new ChestUpgradeEvent($blockClicked, $output);
			$event->call();
			if (!$event->isCancelled()) {
				$contents = $tile->getInventory()->getContents();
				$player->getWorld()->setBlock($blockClicked->getPosition(), $output);

				$newTile = $world->getTile($blockClicked->getPosition());
				if ($newTile instanceof ChestTile) {
					$newTile->getInventory()->setContents($contents);
					$this->pop();
					return ItemUseResult::SUCCESS;
				} // todo: throw exception if newTile is null?
			}
		}
		return ItemUseResult::FAIL;
	}
}