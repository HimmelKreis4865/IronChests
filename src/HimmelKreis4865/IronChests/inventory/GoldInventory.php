<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\inventory;

use himmelkreis4865\ModSmith\inventory\helper\Dimension;
use pocketmine\world\Position;

class GoldInventory extends CustomChestInventory {

	public function __construct(Position $holder) {
		parent::__construct($holder, "Gold Chest", new Dimension(9, 7));
	}
}