<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests\block;

use customiesdevs\customies\block\permutations\BlockProperty;
use customiesdevs\customies\block\permutations\Permutable;
use customiesdevs\customies\block\permutations\Permutation;
use customiesdevs\customies\block\permutations\Permutations;
use customiesdevs\customies\block\permutations\RotatableTrait;
use himmelkreis4865\IronChests\block\tile\ChestTile;
use himmelkreis4865\IronChests\IronChests;
use pocketmine\block\Block;
use pocketmine\block\Transparent;
use pocketmine\data\bedrock\block\convert\BlockStateReader;
use pocketmine\data\bedrock\block\convert\BlockStateWriter;
use pocketmine\data\runtime\RuntimeDataDescriber;
use pocketmine\item\Item;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

class ChestBlock extends Transparent implements Permutable {
	use RotatableTrait {
		getBlockProperties as rotatableBlockProperties;
		getPermutations as rotatablePermutations;
		getCurrentBlockProperties as rotatableCurrentBlockProperties;
		serializeState as serializeRotation;
		deserializeState as deserializeRotation;
	}

	private const STATE_OPEN = IronChests::PREFIX . "open";

	private bool $open = false;

	public function setOpen(bool $open): ChestBlock {
		$this->open = $open;
		return $this;
	}

	public function getBlockProperties(): array {
		return [
			new BlockProperty("customies:rotation", [2, 3, 4, 5]),
			new BlockProperty(self::STATE_OPEN, [false, true])
		];
	}

	public function getPermutations(): array {
		return [ ...$this->rotatablePermutations(),
			(new Permutation("q.block_property('" . self::STATE_OPEN . "') == 0"))
				->withComponent("minecraft:geometry", CompoundTag::create()
					->setString("identifier", "geometry.chest")),
			(new Permutation("q.block_property('" . self::STATE_OPEN . "') == 1"))
				->withComponent("minecraft:geometry", CompoundTag::create()
					->setString("identifier", "geometry.chest_open"))
		];
	}

	public function getCurrentBlockProperties(): array {
		return [$this->facing, $this->open];
	}

	public function readStateFromData(int $id, int $stateMeta): void {
		$blockProperties = Permutations::fromMeta($this, $stateMeta);
		$this->facing = $blockProperties[0] ?? Facing::NORTH;
		$this->open = $blockProperties[1] ?? false;
	}

	public function getLightFilter(): int {
		return 0;
	}

	public function serializeState(BlockStateWriter $blockStateOut): void {
		$this->serializeRotation($blockStateOut);
		$blockStateOut->writeBool(self::STATE_OPEN, $this->open);
	}

	public function deserializeState(BlockStateReader $blockStateIn): void {
		$this->deserializeRotation($blockStateIn);
		$this->open = $blockStateIn->readBool(self::STATE_OPEN);
	}

	protected function describeBlockOnlyState(RuntimeDataDescriber $w): void {
		$w->horizontalFacing($this->facing);
		$w->bool($this->open);
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null, array &$returnedItems = []): bool {
		$tile = $this->position->getWorld()->getTile($this->position);
		if ($player instanceof Player && $tile instanceof ChestTile) {
			$player->setCurrentWindow($tile->getInventory());
		}
		return true;
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null): bool {
		if($player !== null) {
			$this->facing = $player->getHorizontalFacing();
		}
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}
}