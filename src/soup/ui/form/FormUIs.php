<?php
namespace soup\ui\form;

use pocketmine\Player;
use soup\Main;

class FormUIs {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}

	public function openShopForm($player) {
		$api = $this->plugin->getServer()->getPluginManager()->getPlugin("FormAPI");
		if($api === null || $api->isDisabled()){
			return;
		}
		$form = $api->createSimpleForm(function (Player $player, int $data = null){
			$result = $data;
			if($result === null) {
				return;
			}
			switch($result){
				case 0:
					$this->plugin::getClassManager()->setPvpClass($player);
					return;
				case 1:
					$this->plugin::getClassShopManager()->buyKit($player, "ninja");
					return;
				case 2:
					$this->plugin::getClassShopManager()->buyKit($player, "tank");
					break;
				case 3:
					$this->plugin::getClassShopManager()->buyKit($player, "archer");
					break;
				case 4:
					$this->plugin::getClassShopManager()->buyKit($player, "launcher");
					break;
				case 5:
					$this->plugin::getClassShopManager()->buyKit($player, "freezer");
					break;
			}
		});
		$form->setTitle("§l§cClass Shop");
		$form->setContent("§eIf You Own a Class, Click It To Equip It! If Not, Tap It To Buy It!\n§fYour Credits: §e".$this->plugin->playerdata->get($player->getName())["credits"].".");
		$form->addButton("§ePVP Kit\n§aPurchased!");
		$form->addButton($this->plugin->purchasedata->get($player->getName())["ninja"] ? "§eNinja\n§aPurchased!":"§eNinja\n§cPurchase: 500C");
		$form->addButton($this->plugin->purchasedata->get($player->getName())["tank"] ? "§eTank\n§aPurchased!":"§eTank\n§cPurchase: 250C");
		$form->addButton($this->plugin->purchasedata->get($player->getName())["archer"] ? "§eArcher\n§aPurchased!":"§eArcher\n§cPurchase: 350C");
		$form->addButton($this->plugin->purchasedata->get($player->getName())["launcher"] ? "§eLauncher\n§aPurchased!":"§eLauncher\n§cPurchase: 1000C");
		$form->addButton($this->plugin->purchasedata->get($player->getName())["freeze"] ? "§eFreezer\n§aPurchased!":"§eFreezer\n§cPurchase: 750C");
		$form->sendToPlayer($player);
	}
}