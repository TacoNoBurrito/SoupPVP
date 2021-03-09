<?php
namespace soup\classes;
use pocketmine\item\Durable;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use soup\Main;

class ClassManager {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function setIdlingClass(Player $player) {
		$this->plugin->classes[$player->getName()] = "idling";
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
		$player->getInventory()->setItem(4, Item::get(ItemIds::NETHER_STAR)->setCustomName("§r§fClaim Last Kit"));
		$player->getInventory()->setItem(1, Item::get(ItemIds::DYE, 5)->setCustomName("§r§fOpen Perks"));
		$player->getInventory()->setItem(0, Item::get(ItemIds::EMERALD)->setCustomName("§r§fOpen Shop"));
	}
	public function setPvpClass(Player $player) {
		$this->plugin->lastkit[$player->getName()] = "pvp";
		$this->plugin->classes[$player->getName()] = "pvp";
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
		$item = Item::get(306,0,1);
		if ($item instanceof Durable) {
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setHelmet($item);
		}
		$item = Item::get(307,0,1);
		if ($item instanceof Durable) {
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setChestplate($item);
		}
		$item = Item::get(308,0,1);
		if ($item instanceof Durable) {
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setLeggings($item);
		}
		$item = Item::get(309,0,1);
		if ($item instanceof Durable) {
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setBoots($item);
		}
		$item = Item::get(ItemIds::DIAMOND_SWORD,0,1);
		if ($item instanceof Durable) {
			$item->setUnbreakable(true);
			$player->getInventory()->addItem($item);
		}
		$item = Item::get(ItemIds::MUSHROOM_STEW, 0, 35);
		$player->getInventory()->addItem($item);
	}
	public function setNinjaClass($player) : void {
		$this->plugin->lastkit[$player->getName()] = "ninja";
		$this->plugin->classes[$player->getName()] = "ninja";
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
		$item = Item::get(ItemIds::DIAMOND_SWORD,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::SHARPNESS);
			$enchInstance = new EnchantmentInstance($enchantment, 3);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getInventory()->addItem($item);
		}
		$item = Item::get(ItemIds::GLASS)->setCustomName("Ninja Ability");
		$player->getInventory()->addItem($item);
		$item = Item::get(ItemIds::MUSHROOM_STEW, 0, 35);
		$player->getInventory()->addItem($item);
	}
	public function setFreezerClass($player) : void {
		$this->plugin->lastkit[$player->getName()] = "freeze";
		$this->plugin->classes[$player->getName()] = "freeze";
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
		$item = Item::get(ItemIds::LEATHER_HELMET,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::PROTECTION);
			$enchInstance = new EnchantmentInstance($enchantment, 2);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setHelmet($item);
		}
		$item = Item::get(ItemIds::LEATHER_CHESTPLATE,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::PROTECTION);
			$enchInstance = new EnchantmentInstance($enchantment, 2);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setChestplate($item);
		}
		$item = Item::get(ItemIds::LEATHER_LEGGINGS,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::PROTECTION);
			$enchInstance = new EnchantmentInstance($enchantment, 2);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setLeggings($item);
		}
		$item = Item::get(ItemIds::LEATHER_BOOTS,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::PROTECTION);
			$enchInstance = new EnchantmentInstance($enchantment, 2);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setBoots($item);
		}
		$item = Item::get(ItemIds::STONE_SWORD,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::SHARPNESS);
			$enchInstance = new EnchantmentInstance($enchantment, 2);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getInventory()->addItem($item);
		}
		$item = Item::get(ItemIds::PACKED_ICE)->setCustomName("Freezer Ability");
		$player->getInventory()->addItem($item);
		$item = Item::get(ItemIds::MUSHROOM_STEW, 0, 35);
		$player->getInventory()->addItem($item);
	}
	public function setTankClass($player) : void {
		$this->plugin->lastkit[$player->getName()] = "tank";
		$this->plugin->classes[$player->getName()] = "tank";
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
		$item = Item::get(ItemIds::STONE_SWORD,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::SHARPNESS);
			$enchInstance = new EnchantmentInstance($enchantment, 3);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getInventory()->addItem($item);
		}
		$item = Item::get(ItemIds::LEATHER_HELMET,0,1);
		if ($item instanceof Durable) {
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setHelmet($item);
		}
		$item = Item::get(ItemIds::DIAMOND_CHESTPLATE,0,1);
		if ($item instanceof Durable) {
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setChestplate($item);
		}
		$item = Item::get(ItemIds::DIAMOND_LEGGINGS,0,1);
		if ($item instanceof Durable) {
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setLeggings($item);
		}
		$item = Item::get(ItemIds::DIAMOND_BOOTS,0,1);
		if ($item instanceof Durable) {
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setBoots($item);
		}
		$item = Item::get(ItemIds::MUSHROOM_STEW, 0, 36);
		$player->getInventory()->addItem($item);
	}
	public function setLauncherClass($player) : void {
		$this->plugin->lastkit[$player->getName()] = "launcher";
		$this->plugin->classes[$player->getName()] = "launcher";
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
		$item = Item::get(ItemIds::IRON_SWORD, 0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::SHARPNESS);
			$enchInstance = new EnchantmentInstance($enchantment, 2);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getInventory()->addItem($item);
		}
		$item = Item::get(ItemIds::LEATHER_HELMET,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::PROTECTION);
			$enchInstance = new EnchantmentInstance($enchantment, 1);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setHelmet($item);
		}
		$item = Item::get(ItemIds::LEATHER_CHESTPLATE,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::PROTECTION);
			$enchInstance = new EnchantmentInstance($enchantment, 1);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setChestplate($item);
		}
		$item = Item::get(ItemIds::LEATHER_LEGGINGS,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::PROTECTION);
			$enchInstance = new EnchantmentInstance($enchantment, 1);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setLeggings($item);
		}
		$item = Item::get(ItemIds::LEATHER_BOOTS,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::PROTECTION);
			$enchInstance = new EnchantmentInstance($enchantment, 1);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setBoots($item);
		}
		$item = Item::get(ItemIds::MUSHROOM_STEW, 0, 36);
		$player->getInventory()->addItem($item);
		$item = Item::get(ItemIds::BLAZE_POWDER);
		$item->setCustomName("Launcher Ability");
		$player->getInventory()->setItem(1, $item);
	}
	public function setArcherClass($player) : void {
		$this->plugin->lastkit[$player->getName()] = "archer";
		$this->plugin->classes[$player->getName()] = "archer";
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
		$item = Item::get(ItemIds::STONE_SWORD,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::SHARPNESS);
			$enchInstance = new EnchantmentInstance($enchantment, 3);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getInventory()->addItem($item);
		}
		$item = Item::get(ItemIds::CHAIN_HELMET,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::PROTECTION);
			$enchInstance = new EnchantmentInstance($enchantment, 1);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setHelmet($item);
		}
		$item = Item::get(ItemIds::CHAIN_CHESTPLATE,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::PROTECTION);
			$enchInstance = new EnchantmentInstance($enchantment, 1);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setChestplate($item);
		}
		$item = Item::get(ItemIds::CHAIN_LEGGINGS,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::PROTECTION);
			$enchInstance = new EnchantmentInstance($enchantment, 1);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setLeggings($item);
		}
		$item = Item::get(ItemIds::CHAIN_BOOTS,0,1);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::PROTECTION);
			$enchInstance = new EnchantmentInstance($enchantment, 1);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getArmorInventory()->setBoots($item);
		}
		$item = Item::get(ItemIds::BOW);
		if ($item instanceof Durable) {
			$enchantment = Enchantment::getEnchantment(Enchantment::INFINITY);
			$enchInstance = new EnchantmentInstance($enchantment, 1);
			$item->addEnchantment($enchInstance);
			$enchantment = Enchantment::getEnchantment(Enchantment::POWER);
			$enchInstance = new EnchantmentInstance($enchantment, 4);
			$item->addEnchantment($enchInstance);
			$enchantment = Enchantment::getEnchantment(Enchantment::FLAME);
			$enchInstance = new EnchantmentInstance($enchantment, 1);
			$item->addEnchantment($enchInstance);
			$item->setUnbreakable(true);
			$player->getInventory()->addItem($item);
		}
		$item = Item::get(ItemIds::MUSHROOM_STEW, 0, 36);
		$player->getInventory()->addItem($item);
		$item = Item::get(ItemIds::ARROW);
		$player->getInventory()->setItem(10,$item);
	}
}