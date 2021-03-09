<?php
namespace soup\ui\inventory;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\Player;
use soup\Main;

class InventoryUIs {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}

	public function openShopForm($player) {
		$menu = InvMenu::create(InvMenu::TYPE_CHEST);
		$inventory = $menu->getInventory();
		for ($i=0;$i<27;$i++) {
			$inventory->setItem($i, Item::get(ItemIds::STAINED_GLASS, 7));
		}
		$inventory->setItem(10, Item::get(ItemIds::DIAMOND_SWORD)->setCustomName("§ePvP"));
		$inventory->setItem(11, Item::get(ItemIds::SUGAR)->setCustomName($this->plugin->purchasedata->get($player->getName())["ninja"] ? "§eNinja\n§aPurchased!":"§eNinja\n§cPurchase: 500C"));
		$inventory->setItem(12, Item::get(ItemIds::DIAMOND_CHESTPLATE)->setCustomName($this->plugin->purchasedata->get($player->getName())["tank"] ? "§eTank\n§aPurchased!":"§eTank\n§cPurchase: 250C"));
		$inventory->setItem(13, Item::get(ItemIds::BOW)->setCustomName($this->plugin->purchasedata->get($player->getName())["archer"] ? "§eArcher\n§aPurchased!":"§eArcher\n§cPurchase: 350C"));
		$inventory->setItem(14, Item::get(ItemIds::BLAZE_POWDER)->setCustomName($this->plugin->purchasedata->get($player->getName())["launcher"] ? "§eLauncher\n§aPurchased!":"§eLauncher\n§cPurchase: 1000C"));
		$inventory->setItem(15, Item::get(ItemIds::PACKED_ICE)->setCustomName($this->plugin->purchasedata->get($player->getName())["freeze"] ? "§eFreezer\n§aPurchased!":"§eFreezer\n§cPurchase: 750C"));
		$menu->setListener(function(InvMenuTransaction $transaction) : InvMenuTransactionResult{
			$player = $transaction->getPlayer();
			$itemClicked = $transaction->getItemClicked();
			switch($itemClicked->getCustomName()) {
				case "§eFreezer\n§aPurchased!":
				case "§eFreezer\n§cPurchase: 750C":
					$this->plugin::getClassShopManager()->buyKit($player, "freezer");
					$transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
					break;
				case "§ePvP":
					$this->plugin::getClassManager()->setPvpClass($player);
					$transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
					break;
				case "§eNinja\n§cPurchase: 500C":
				case "§eNinja\n§aPurchased!":
					$this->plugin::getClassShopManager()->buyKit($player, "ninja");
					$transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
					break;
				case "§eTank\n§aPurchased!":
				case "§eTank\n§cPurchase: 250C":
					$this->plugin::getClassShopManager()->buyKit($player, "tank");
					$transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
					break;
				case "§eArcher\n§cPurchase: 350C":
				case "§eArcher\n§aPurchased!":
					$this->plugin::getClassShopManager()->buyKit($player, "archer");
					$transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
					break;
				case "§eLauncher\n§cPurchase: 1000C":
				case "§eLauncher\n§aPurchased!":
					$this->plugin::getClassShopManager()->buyKit($player, "launcher");
					$transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
					break;
			}
			return $transaction->discard();
		});
		$menu->send($player, "Classes Menu");
	}

	public function openPerkShop($player) {
		$menu = InvMenu::create(InvMenu::TYPE_CHEST);
		$inventory = $menu->getInventory();
		for ($i=0;$i<27;$i++) {
			$inventory->setItem($i, Item::get(ItemIds::STAINED_GLASS, 7));
		}
		$inventory->setItem(10, Item::get(ItemIds::RED_GLAZED_TERRACOTTA)->setCustomName("§r§c§lMONSTER")->setLore(["§r§eCurrent Level: §a".$this->plugin->abilitydata->get($player->getName())["monster-level"]."\n§cThis ability gives you strength after\n§cevery kill."]));

		$menu->setListener(function(InvMenuTransaction $transaction) : InvMenuTransactionResult{
			$player = $transaction->getPlayer();
			$itemClicked = $transaction->getItemClicked();
			switch($itemClicked->getCustomName()) {
				case "§r§c§lMONSTER":
					$this->plugin::getPerkShopManager()->buyPerk($player, "monster");
					$transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
					break;
			}
			return $transaction->discard();
		});
		$menu->send($player, "Perks Menu");
	}
}