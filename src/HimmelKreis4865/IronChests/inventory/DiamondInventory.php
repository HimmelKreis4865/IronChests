<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\inventory;

use himmelkreis4865\ModSmith\inventory\helper\Dimension;
use pocketmine\world\Position;

class DiamondInventory extends CustomChestInventory {

	public function __construct(Position $holder) {
		parent::__construct($holder, "Diamond Chest", new Dimension(14, 7));
	}
}