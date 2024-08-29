<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\event;

use HimmelKreis4865\IronChests\block\ChestBlock;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\Event;

class ChestUpgradeEvent extends Event implements Cancellable {
	use CancellableTrait;

	public function __construct(
		public readonly ChestBlock $previousChest,
		public readonly ChestBlock $upgradeChest
	) {
	}
}