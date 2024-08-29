<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\block\tile;

use HimmelKreis4865\IronChests\inventory\CustomChestInventory;
use pocketmine\block\tile\Container;
use pocketmine\block\tile\ContainerTrait;
use pocketmine\block\tile\Tile;
use pocketmine\inventory\CallbackInventoryListener;
use pocketmine\inventory\Inventory;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\Position;
use pocketmine\world\World;

abstract class ChestTile extends Tile implements Container {
	use ContainerTrait;

	private CustomChestInventory $inventory;

	/**
	 * @param class-string<CustomChestInventory> $inventoryClass
	 */
	public function __construct(World $world, Vector3 $pos, string $inventoryClass) {

		parent::__construct($world, $pos);
		$this->inventory = new $inventoryClass(Position::fromObject($pos, $world));
		$this->inventory->getListeners()->add(CallbackInventoryListener::onAnyChange(
			static function(Inventory $unused) use ($world, $pos): void {
				$world->scheduleDelayedBlockUpdate($pos, 1);
			})
		);
	}

	public function getRealInventory(): Inventory {
		return $this->inventory;
	}

	public function getInventory(): Inventory {
		return $this->inventory;
	}

	public function readSaveData(CompoundTag $nbt): void {
		$this->loadItems($nbt);
	}

	protected function writeSaveData(CompoundTag $nbt): void {
		$this->saveItems($nbt);
	}

	public function onUpdate(): void { }

	public function close(): void {
		foreach ($this->inventory->getViewers() as $viewer) {
			$viewer->removeCurrentWindow();
		}
		parent::close();
	}
}

