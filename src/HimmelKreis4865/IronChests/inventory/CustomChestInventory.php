<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\inventory;

use HimmelKreis4865\IronChests\block\ChestBlock;
use HimmelKreis4865\IronChests\inventory\helper\ChestGridSizes;
use HimmelKreis4865\IronChests\IronChests;
use himmelkreis4865\ModSmith\inventory\component\Grid;
use himmelkreis4865\ModSmith\inventory\component\Text;
use himmelkreis4865\ModSmith\inventory\CustomInventory;
use himmelkreis4865\ModSmith\inventory\helper\Dimension;
use himmelkreis4865\ModSmith\inventory\RootPanel;
use pocketmine\block\inventory\AnimatedBlockInventoryTrait;
use pocketmine\world\Position;
use pocketmine\world\sound\ChestCloseSound;
use pocketmine\world\sound\ChestOpenSound;
use pocketmine\world\sound\Sound;
use pocketmine\world\World;
use RuntimeException;
use function max;

abstract class CustomChestInventory extends CustomInventory {
	use AnimatedBlockInventoryTrait;

	protected static string $identifier;

	public function __construct(protected Position $holder) {
		parent::__construct();
	}

	public static function build(): RootPanel {
		$gridSize = ChestGridSizes::getInstance()->get(static::$identifier);
		if (!$gridSize) {
			throw new RuntimeException("Grid size for chest " . static::$identifier . " not found!");
		}
		$windowSize = ChestGridSizes::gridSizeToWindowSize($gridSize);

		$root = new RootPanel(new Dimension(max($windowSize->x, self::DEFAULT_WIDTH), max($windowSize->y, self::SMALL_CHEST_HEIGHT)));
		$root->add(Text::chestTitle("tile." . IronChests::PREFIX . static::$identifier . ".name", localized: true));
		$root->add(new Grid($gridSize, offset: new Dimension(7, 20)));
		return $root;
	}

	public static function getName(): string {
		return static::$identifier;
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