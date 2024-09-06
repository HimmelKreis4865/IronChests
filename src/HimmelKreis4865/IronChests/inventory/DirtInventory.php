<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\inventory;

use HimmelKreis4865\IronChests\block\IronChestTypeNames;
use himmelkreis4865\ModSmith\inventory\component\Slot;
use himmelkreis4865\ModSmith\inventory\component\Text;
use himmelkreis4865\ModSmith\inventory\helper\Anchor;
use himmelkreis4865\ModSmith\inventory\helper\Dimension;
use himmelkreis4865\ModSmith\inventory\RootPanel;
use himmelkreis4865\ModSmith\inventory\types\AnchorType;
use pocketmine\block\VanillaBlocks;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;

class DirtInventory extends CustomChestInventory {

	protected static string $identifier = "dirt_chest";

	public static function build(): RootPanel {
		$root = new RootPanel();
		$root->add(Text::chestTitle("tile." . IronChestTypeNames::DIRT_CHEST . ".name", localized: true));
		$root->add(new Slot(0, offset: new Dimension(0, 5), anchor: new Anchor(AnchorType::CENTER, AnchorType::CENTER)));
		return $root;
	}

	public function onTransaction(SlotChangeAction $action, Player $player): bool {
		return !$action->getTargetItem()->equals(VanillaBlocks::DIRT()->asItem()) && !$action->getTargetItem()->equals(VanillaItems::AIR());
	}
}