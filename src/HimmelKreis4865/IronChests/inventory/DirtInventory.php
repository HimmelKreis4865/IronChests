<?php

declare(strict_types=1);

namespace HimmelKreis4865\IronChests\inventory;

use himmelkreis4865\ModSmith\inventory\component\Slot;
use himmelkreis4865\ModSmith\inventory\component\Text;
use himmelkreis4865\ModSmith\inventory\helper\Anchor;
use himmelkreis4865\ModSmith\inventory\helper\Dimension;
use himmelkreis4865\ModSmith\inventory\types\AnchorType;
use pocketmine\block\VanillaBlocks;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\world\Position;

class DirtInventory extends CustomChestInventory {

	public function __construct(Position $holder) {
		parent::__construct($holder, "Dirt Chest", new Dimension(1, 1), [
			Text::chestTitle("Dirt Chest"),
			new Slot(0, offset: new Dimension(0, 5), anchor: new Anchor(AnchorType::CENTER, AnchorType::CENTER))
		]);
	}

	public function onTransaction(SlotChangeAction $action, Player $player): bool {
		return !$action->getTargetItem()->equals(VanillaBlocks::DIRT()->asItem()) && !$action->getTargetItem()->equals(VanillaItems::AIR());
	}
}