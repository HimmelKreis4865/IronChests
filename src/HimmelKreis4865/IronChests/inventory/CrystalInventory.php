<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\inventory;

use himmelkreis4865\ModSmith\inventory\helper\Dimension;
use pocketmine\world\Position;

class CrystalInventory extends CustomChestInventory {

	public function __construct(Position $holder) {
		parent::__construct($holder, "Crystal Chest", new Dimension(14, 7));
	}
}