# IronChests
This PocketMine-MP plugin is inspired by the original [IronChests mod for Java Edition](https://www.curseforge.com/minecraft/mc-mods/iron-chests).

This plugin uses their textures & mechanics, which means you can craft the same recipes.

## Blocks
All added blocks are chests:

| Name           | Identifier                   | Grid size | Features    |
|----------------|------------------------------|-----------|-------------|
| Dirt Chest     | `iron_chests:dirt_chest`     | 1x1       | -           |
| Copper Chest   | `iron_chests:copper_chest`   | 9x4       | -           |
| Iron Chest     | `iron_chests:iron_chest`     | 9x6       | -           |
| Gold Chest     | `iron_chests:gold_chest`     | 9x7       | -           |
| Diamond Chest  | `iron_chests:diamond_chest`  | 14x7      | -           |
| Obsidian Chest | `iron_chests:obsidian_chest` | 14x7      | Blastproof  |
| Crystal Chest  | `iron_chests:crystal_chest`  | 14x7      | Transparent |

## Items
All added items are chest upgrades which can be applied by shift clicking on the correct chest

| Identifier                             | Initial Chest | New Chest      |
|----------------------------------------|---------------|----------------|
| `iron_chests:wood_copper_upgrade`      | Chest         | Copper Chest   |
| `iron_chests:wood_iron_upgrade`        | Chest         | Iron Chest     |
| `iron_chests:copper_iron_upgrade`      | Copper Chest  | Iron Chest     |
| `iron_chests:iron_gold_upgrade`        | Iron Chest    | Gold Chest     |
| `iron_chests:gold_diamond_upgrade`     | Gold Chest    | Diamond Chest  |
| `iron_chests:diamond_crystal_upgrade`  | Diamond Chest | Crystal Chest  |
| `iron_chests:diamond_obsidian_upgrade` | Diamond Chest | Obsidian Chest |

## Translations
If you are unhappy or missing some translations, you can always edit them yourself in plugin_data/IronChests/translations.yml

To add a new language, copy the all translation keys from another language and replace the locale code.
