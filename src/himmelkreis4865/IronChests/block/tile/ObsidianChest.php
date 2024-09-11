<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\block\tile;

use himmelkreis4865\IronChests\inventory\ObsidianInventory;
use pocketmine\math\Vector3;
use pocketmine\world\World;

final class ObsidianChest extends ChestTile {

	public function __construct(World $world, Vector3 $pos) {
		parent::__construct($world, $pos, ObsidianInventory::class);
	}
}