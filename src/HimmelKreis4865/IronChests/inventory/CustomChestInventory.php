<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\inventory;

use HimmelKreis4865\IronChests\block\ChestBlock;
use himmelkreis4865\ModSmith\inventory\component\Grid;
use himmelkreis4865\ModSmith\inventory\component\Text;
use himmelkreis4865\ModSmith\inventory\CustomInventory;
use himmelkreis4865\ModSmith\inventory\helper\Dimension;
use pocketmine\block\inventory\AnimatedBlockInventoryTrait;
use pocketmine\world\Position;
use pocketmine\world\sound\ChestCloseSound;
use pocketmine\world\sound\ChestOpenSound;
use pocketmine\world\sound\Sound;
use pocketmine\world\World;
use function max;
use function str_replace;
use function strtolower;

abstract class CustomChestInventory extends CustomInventory {
	use AnimatedBlockInventoryTrait;

	public function __construct(protected Position $holder, string $name, Dimension $gridSize, ?array $components = null) {
		$size = $gridSize->multiply(18, 18)->add(14, 18);
		parent::__construct(strtolower(str_replace(" ", "_", $name)), new Dimension(max($size->x, self::DEFAULT_WIDTH), max($size->y, self::SMALL_CHEST_HEIGHT)), $components ?? [
			Text::chestTitle($name),
			new Grid($gridSize, offset: new Dimension(7, 18))
		]);
	}

	public function getHolder(): Position {
		return $this->holder;
	}

	protected function getOpenSound(): Sound {
		return new ChestOpenSound();
	}

	protected function getCloseSound(): Sound {
		return new ChestCloseSound();
	}

	protected function animateBlock(bool $isOpen): void {
		$world = $this->holder->world;
		if ($world instanceof World) {
			$block = $world->getBlock($this->holder);
			if (!$block instanceof ChestBlock) return;

			$world->setBlock($this->holder, $block->setOpen($isOpen));
		}
	}
}