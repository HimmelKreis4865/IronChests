<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\event;

use himmelkreis4865\IronChests\block\ChestBlock;
use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\Event;

class ChestUpgradeEvent extends Event implements Cancellable {
	use CancellableTrait;

	public function __construct(
		public readonly Block $previousChest,
		public readonly ChestBlock $upgradeChest
	) {
	}
}