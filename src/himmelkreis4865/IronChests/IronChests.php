<?php

declare(strict_types=1);

namespace himmelkreis4865\IronChests;

use customiesdevs\customies\block\CustomiesBlockFactory;
use customiesdevs\customies\block\Material;
use customiesdevs\customies\block\Model;
use customiesdevs\customies\item\CreativeInventoryInfo;
use customiesdevs\customies\item\CustomiesItemFactory;
use himmelkreis4865\IronChests\block\ChestBlock;
use himmelkreis4865\IronChests\block\IronChestBlocks;
use himmelkreis4865\IronChests\block\tile\ChestTile;
use himmelkreis4865\IronChests\block\tile\CopperChest;
use himmelkreis4865\IronChests\block\tile\CrystalChest;
use himmelkreis4865\IronChests\block\tile\DiamondChest;
use himmelkreis4865\IronChests\block\tile\DirtChest;
use himmelkreis4865\IronChests\block\tile\GoldChest;
use himmelkreis4865\IronChests\block\tile\IronChest;
use himmelkreis4865\IronChests\block\tile\ObsidianChest;
use himmelkreis4865\IronChests\inventory\CopperInventory;
use himmelkreis4865\IronChests\inventory\CrystalInventory;
use himmelkreis4865\IronChests\inventory\DiamondInventory;
use himmelkreis4865\IronChests\inventory\DirtInventory;
use himmelkreis4865\IronChests\inventory\GoldInventory;
use himmelkreis4865\IronChests\inventory\IronInventory;
use himmelkreis4865\IronChests\inventory\ObsidianInventory;
use himmelkreis4865\IronChests\item\CopperIronUpgrade;
use himmelkreis4865\IronChests\item\DiamondCrystalUpgrade;
use himmelkreis4865\IronChests\item\DiamondObsidianUpgrade;
use himmelkreis4865\IronChests\item\GoldDiamondUpgrade;
use himmelkreis4865\IronChests\item\IronGoldUpgrade;
use himmelkreis4865\IronChests\item\ItemUpgradeShard;
use himmelkreis4865\IronChests\item\WoodCopperUpgrade;
use himmelkreis4865\IronChests\item\WoodIronUpgrade;
use himmelkreis4865\ModSmith\block\BlockAssetRegistry;
use himmelkreis4865\ModSmith\inventory\CustomInventoryRegistry;
use himmelkreis4865\ModSmith\item\ItemAssetRegistry;
use himmelkreis4865\ModSmith\utils\Language;
use himmelkreis4865\ModSmith\utils\LanguageRegistry;
use himmelkreis4865\ModSmith\utils\Texture;
use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockTypeIds;
use pocketmine\block\BlockTypeInfo;
use pocketmine\block\tile\TileFactory;
use pocketmine\block\VanillaBlocks;
use pocketmine\crafting\ExactRecipeIngredient;
use pocketmine\crafting\RecipeIngredient;
use pocketmine\crafting\ShapedRecipe;
use pocketmine\crafting\TagWildcardRecipeIngredient;
use pocketmine\data\bedrock\item\ItemTypeNames;
use pocketmine\item\ToolTier;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use pocketmine\world\Position;
use RuntimeException;
use function igbinary_serialize;
use function igbinary_unserialize;

final class IronChests extends PluginBase {
	use SingletonTrait;

	public const PREFIX = "iron_chests:";

	protected function onEnable(): void {
		TileFactory::getInstance()->register(CopperChest::class, [self::PREFIX . "copper_chest"]);
		TileFactory::getInstance()->register(CrystalChest::class, [self::PREFIX . "crystal_chest"]);
		TileFactory::getInstance()->register(DiamondChest::class, [self::PREFIX . "diamond_chest"]);
		TileFactory::getInstance()->register(DirtChest::class, [self::PREFIX . "dirt_chest"]);
		TileFactory::getInstance()->register(GoldChest::class, [self::PREFIX . "gold_chest"]);
		TileFactory::getInstance()->register(IronChest::class, [self::PREFIX . "iron_chest"]);
		TileFactory::getInstance()->register(ObsidianChest::class, [self::PREFIX . "obsidian_chest"]);

		BlockAssetRegistry::getInstance()->addGeometry($this->getResourceFolder() . "models/chest.json", "chest.json");
		BlockAssetRegistry::getInstance()->addGeometry($this->getResourceFolder() . "models/chest_open.json", "chest_open.json");

		$this->loadTranslations();

		$pos = Position::fromObject(Vector3::zero(), null);
		CustomInventoryRegistry::getInstance()->register(CopperInventory::class);
		CustomInventoryRegistry::getInstance()->register(DirtInventory::class);
		CustomInventoryRegistry::getInstance()->register(CrystalInventory::class);
		CustomInventoryRegistry::getInstance()->register(DiamondInventory::class);
		CustomInventoryRegistry::getInstance()->register(GoldInventory::class);
		CustomInventoryRegistry::getInstance()->register(IronInventory::class);
		CustomInventoryRegistry::getInstance()->register(ObsidianInventory::class);

		$this->registerChest("dirt_chest", "Dirt Chest", DirtChest::class, BlockBreakInfo::pickaxe(3.0, ToolTier::STONE, 6.0));
		$this->registerChest("copper_chest", "Copper Chest", CopperChest::class, BlockBreakInfo::pickaxe(3.0, ToolTier::STONE, 6.0));
		$this->registerChest("iron_chest", "Iron Chest", IronChest::class, BlockBreakInfo::pickaxe(3.0, ToolTier::STONE, 6.0));
		$this->registerChest("gold_chest", "Gold Chest", GoldChest::class, BlockBreakInfo::pickaxe(3.0, ToolTier::STONE, 6.0));
		$this->registerChest("diamond_chest", "Diamond Chest", DiamondChest::class, BlockBreakInfo::pickaxe(3.0, ToolTier::STONE, 6.0));
		$this->registerChest("crystal_chest", "Crystal Chest", CrystalChest::class, BlockBreakInfo::pickaxe(3.0, ToolTier::STONE, 6.0), Material::RENDER_METHOD_BLEND);
		$this->registerChest("obsidian_chest", "Obsidian Chest", ObsidianChest::class, BlockBreakInfo::pickaxe(50.0, ToolTier::DIAMOND, 1200.0));

		$this->registerChestRecipe(IronChestBlocks::DIRT_CHEST(), new ExactRecipeIngredient(VanillaBlocks::DIRT()->asItem()), VanillaBlocks::CHEST());
		$this->registerChestRecipe(IronChestBlocks::COPPER_CHEST(), new ExactRecipeIngredient(VanillaItems::COPPER_INGOT()), VanillaBlocks::CHEST());
		$this->registerChestRecipe(IronChestBlocks::IRON_CHEST(), new ExactRecipeIngredient(VanillaItems::IRON_INGOT()), VanillaBlocks::CHEST());
		$this->registerChestRecipe(IronChestBlocks::GOLD_CHEST(), new ExactRecipeIngredient(VanillaItems::GOLD_INGOT()), IronChestBlocks::IRON_CHEST());
		$this->registerChestRecipe(IronChestBlocks::DIAMOND_CHEST(), new ExactRecipeIngredient(VanillaItems::DIAMOND()), IronChestBlocks::GOLD_CHEST());
		$this->registerChestRecipe(IronChestBlocks::CRYSTAL_CHEST(), new ExactRecipeIngredient(VanillaBlocks::GLASS()->asItem()), IronChestBlocks::DIAMOND_CHEST());
		$this->registerChestRecipe(IronChestBlocks::OBSIDIAN_CHEST(), new ExactRecipeIngredient(VanillaBlocks::OBSIDIAN()->asItem()), IronChestBlocks::DIAMOND_CHEST());

		$this->registerUpgradeShard(
			"wood_iron_upgrade", "Wood To Iron Chest Upgrade",
			WoodIronUpgrade::class,
			new ExactRecipeIngredient(VanillaItems::IRON_INGOT()),
			new TagWildcardRecipeIngredient(ItemTypeNames::PLANKS)
		);
		$this->registerUpgradeShard(
			"wood_copper_upgrade", "Wood To Copper Chest Upgrade",
			WoodCopperUpgrade::class,
			new ExactRecipeIngredient(VanillaItems::COPPER_INGOT()),
			new TagWildcardRecipeIngredient(ItemTypeNames::PLANKS)
		);
		$this->registerUpgradeShard(
			"copper_iron_upgrade", "Copper To Iron Chest Upgrade",
			CopperIronUpgrade::class,
			new ExactRecipeIngredient(VanillaItems::IRON_INGOT()),
			new ExactRecipeIngredient(VanillaItems::COPPER_INGOT())
		);
		$this->registerUpgradeShard(
			"iron_gold_upgrade", "Iron To Gold Chest Upgrade",
			IronGoldUpgrade::class,
			new ExactRecipeIngredient(VanillaItems::GOLD_INGOT()),
			new ExactRecipeIngredient(VanillaItems::IRON_INGOT())
		);
		$this->registerUpgradeShard(
			"gold_diamond_upgrade", "Gold To Diamond Chest Upgrade",
			GoldDiamondUpgrade::class,
			new ExactRecipeIngredient(VanillaItems::DIAMOND()),
			new ExactRecipeIngredient(VanillaItems::GOLD_INGOT())
		);
		$this->registerUpgradeShard(
			"diamond_crystal_upgrade", "Diamond To Crystal Chest Upgrade",
			DiamondCrystalUpgrade::class,
			new ExactRecipeIngredient(VanillaBlocks::GLASS()->asItem()),
			new ExactRecipeIngredient(VanillaItems::DIAMOND())
		);
		$this->registerUpgradeShard(
			"diamond_obsidian_upgrade", "Diamond To Obsidian Chest Upgrade",
			DiamondObsidianUpgrade::class,
			new ExactRecipeIngredient(VanillaBlocks::OBSIDIAN()->asItem()),
			new ExactRecipeIngredient(VanillaItems::DIAMOND())
		);
	}

	/**
	 * @param class-string<ChestTile> $tileClass
	 */
	private function registerChest(string $identifier, string $name, string $tileClass, BlockBreakInfo $breakInfo, string $renderMethod = Material::RENDER_METHOD_ALPHA_TEST): void {
		$texturePath = $this->getResourceFolder() . "textures/blocks/$identifier.png";
		BlockAssetRegistry::getInstance()->addTexture(Texture::fromFile($texturePath, "textures/blocks/$identifier.png"));

		$breakInfoSerialized = igbinary_serialize($breakInfo);
		if ($breakInfoSerialized === null) {
			throw new RuntimeException("Failed to serialize block break info");
		}
		$typeId = BlockTypeIds::newId();
		CustomiesBlockFactory::getInstance()->registerBlock(
			static fn() => new ChestBlock(
				new BlockIdentifier($typeId, $tileClass),
				$name,
				new BlockTypeInfo(igbinary_unserialize($breakInfoSerialized))
			),
			self::PREFIX . $identifier,
			new Model([
				new Material(Material::TARGET_ALL, $identifier, $renderMethod)
			], "geometry.chest", new Vector3(-7.5, 0, -7.5), new Vector3(15, 15.25, 15)),
			new CreativeInventoryInfo(CreativeInventoryInfo::CATEGORY_ITEMS, CreativeInventoryInfo::GROUP_CHEST)
		);
	}

	private function registerChestRecipe(ChestBlock $chest, RecipeIngredient $material, Block $previousChest): void {
		$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe([
			"AAA",
			"ABA",
			"AAA"
		], [
			"A" => $material,
			"B" => new ExactRecipeIngredient($previousChest->asItem())
		], [
			$chest->asItem()
		]
		));
	}

	/**
	 * @param string                         $identifier this should also match the texture name in the assets
	 * @param class-string<ItemUpgradeShard> $itemClass
	 */
	private function registerUpgradeShard(string $identifier, string $name, string $itemClass, RecipeIngredient $material, RecipeIngredient $previousMaterial): void {
		ItemAssetRegistry::getInstance()->addTexture(Texture::fromFile($this->getResourceFolder() . "textures/items/$identifier.png", "textures/items/$identifier.png"));

		CustomiesItemFactory::getInstance()->registerItem($itemClass, $id = (self::PREFIX . $identifier), $identifier);
		$item = CustomiesItemFactory::getInstance()->get($id);
		$this->getServer()->getCraftingManager()->registerShapedRecipe(new ShapedRecipe([
			"AAA",
			"ABA",
			"AAA"
		], [
			"A" => $material,
			"B" => $previousMaterial
		], [$item]));
	}

	private function loadTranslations(): void {
		$this->saveResource("translations.yml");

		$config = new Config($this->getDataFolder() . "translations.yml", Config::YAML);
		foreach ($config->getAll() as $languageString => $translations) {
			$language = null;
			foreach (Language::cases() as $lang) {
				if ($lang->name === $languageString) {
					$language = $lang;
					break;
				}
			}
			if ($language !== null) {
				LanguageRegistry::getInstance()->translateBlocks($language, $translations["blocks"] ?? []);
				LanguageRegistry::getInstance()->translateItems($language, $translations["items"] ?? []);
			}
		}
	}
}