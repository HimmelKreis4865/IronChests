<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\block;

use customiesdevs\customies\block\CustomiesBlockFactory;
use HimmelKreis4865\IronChests\IronChests;
use pocketmine\utils\RegistryTrait;

/**
 * @method static ChestBlock COPPER_CHEST()
 * @method static ChestBlock CRYSTAL_CHEST()
 * @method static ChestBlock DIAMOND_CHEST()
 * @method static ChestBlock DIRT_CHEST()
 * @method static ChestBlock GOLD_CHEST()
 * @method static ChestBlock IRON_CHEST()
 * @method static ChestBlock OBSIDIAN_CHEST()
 */
final class IronChestBlocks {
	use RegistryTrait;

	protected static function setup(): void {
		$blockFactory = CustomiesBlockFactory::getInstance();

		self::_registryRegister("copper_chest", $blockFactory->get(IronChests::PREFIX . "copper_chest"));
		self::_registryRegister("crystal_chest", $blockFactory->get(IronChests::PREFIX . "crystal_chest"));
		self::_registryRegister("diamond_chest", $blockFactory->get(IronChests::PREFIX . "diamond_chest"));
		self::_registryRegister("dirt_chest", $blockFactory->get(IronChests::PREFIX . "dirt_chest"));
		self::_registryRegister("gold_chest", $blockFactory->get(IronChests::PREFIX . "gold_chest"));
		self::_registryRegister("iron_chest", $blockFactory->get(IronChests::PREFIX . "iron_chest"));
		self::_registryRegister("obsidian_chest", $blockFactory->get(IronChests::PREFIX . "obsidian_chest"));
	}
}