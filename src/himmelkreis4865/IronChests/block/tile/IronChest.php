<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\block\tile;

use himmelkreis4865\IronChests\inventory\IronInventory;
use pocketmine\math\Vector3;
use pocketmine\world\World;

final class IronChest extends ChestTile {

	public function __construct(World $world, Vector3 $pos) {
		parent::__construct($world, $pos, IronInventory::class);
	}
}