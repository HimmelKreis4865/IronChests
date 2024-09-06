<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\inventory\helper;

use himmelkreis4865\ModSmith\inventory\helper\Dimension;
use pocketmine\utils\SingletonTrait;

final class ChestGridSizes {
	use SingletonTrait;

	/** @var array<string, Dimension> $gridSizes */
	private array $gridSizes = [];

	public function __construct() {
		$this->add("copper_chest", new Dimension(9, 4));
		$this->add("crystal_chest", new Dimension(14, 7));
		$this->add("diamond_chest", new Dimension(14, 7));
		$this->add("dirt_chest", new Dimension(1, 1));
		$this->add("gold_chest", new Dimension(9, 7));
		$this->add("iron_chest", new Dimension(9, 6));
		$this->add("obsidian_chest", new Dimension(14, 7));

	}

	public function add(string $identifier, Dimension $dimension): void {
		$this->gridSizes[$identifier] = $dimension;
	}

	public function get(string $identifier): ?Dimension {
		return $this->gridSizes[$identifier] ?? null;
	}

	public static function gridSizeToWindowSize(Dimension $gridSize): Dimension {
		return $gridSize->multiply(18, 18)->add(14, 18);
	}
}