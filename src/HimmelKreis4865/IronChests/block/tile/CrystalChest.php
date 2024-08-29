<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\block\tile;

use HimmelKreis4865\IronChests\inventory\CrystalInventory;
use pocketmine\math\Vector3;
use pocketmine\world\World;
use function var_dump;

final class CrystalChest extends ChestTile {

	public function __construct(World $world, Vector3 $pos) {
		parent::__construct($world, $pos, CrystalInventory::class);
		var_dump("Crystal chest here");
	}
}