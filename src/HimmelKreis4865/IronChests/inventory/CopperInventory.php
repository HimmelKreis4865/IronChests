<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\inventory;

use himmelkreis4865\ModSmith\inventory\helper\Dimension;
use pocketmine\world\Position;

class CopperInventory extends CustomChestInventory {

	public function __construct(Position $holder) {
		parent::__construct($holder, "Copper Chest", new Dimension(9, 4));
	}
}