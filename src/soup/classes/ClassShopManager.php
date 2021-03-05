<?php
namespace soup\classes;
use soup\Main;
use pocketmine\Player;
class ClassShopManager {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function buyKit($player, $kit) {
		switch($kit) {
			case "tank":
				if ($this->plugin->purchasedata->get($player->getName())["tank"] == false) {
					if ($this->plugin->playerdata->get($player->getName())["credits"] >= 250) {
						$this->plugin->purchasedata->setNested($player->getName().".tank", true);
						$this->plugin->purchasedata->save();
						$this->plugin->playerdata->setNested($player->getName().".credits", $this->plugin->playerdata->get($player->getName())["credits"]-250);
						$this->plugin->playerdata->save();
						$this->plugin::getClassManager()->setTankClass($player);
					} else {
						$player->sendMessage("§cYou Need §a" . (250 - $this->plugin->playerdata->get($player->getName())["credits"]) ." §cMore Credits To Purchase This Class!");
					}
				}else{
					$this->plugin::getClassManager()->setTankClass($player);
				}
				break;
			case "ninja":
				if ($this->plugin->purchasedata->get($player->getName())["ninja"] == false) {
					if ($this->plugin->playerdata->get($player->getName())["credits"] >= 500) {
						$this->plugin->purchasedata->setNested($player->getName().".ninja", true);
						$this->plugin->purchasedata->save();
						$this->plugin->playerdata->setNested($player->getName().".credits", $this->plugin->playerdata->get($player->getName())["credits"]-500);
						$this->plugin->playerdata->save();
						$this->plugin::getClassManager()->setNinjaClass($player);
					} else {
						$player->sendMessage("§cYou Need §a" . (500 - $this->plugin->playerdata->get($player->getName())["credits"]) ." §cMore Credits To Purchase This Class!");
					}
				}else{
					$this->plugin::getClassManager()->setNinjaClass($player);
				}
				break;
			case "archer":
				if ($this->plugin->purchasedata->get($player->getName())["archer"] == false) {
					if ($this->plugin->playerdata->get($player->getName())["credits"] >= 350) {
						$this->plugin->purchasedata->setNested($player->getName().".archer", true);
						$this->plugin->purchasedata->save();
						$this->plugin->playerdata->setNested($player->getName().".credits", $this->plugin->playerdata->get($player->getName())["credits"]-350);
						$this->plugin->playerdata->save();
						$this->plugin::getClassManager()->setArcherClass($player);
					} else {
						$player->sendMessage("§cYou Need §a" . (350 - $this->plugin->playerdata->get($player->getName())["credits"]) ." §cMore Credits To Purchase This Class!");
					}
				}else{
					$this->plugin::getClassManager()->setArcherClass($player);
				}
				break;
			case "launcher":
				if ($this->plugin->purchasedata->get($player->getName())["launcher"] == false) {
					if ($this->plugin->playerdata->get($player->getName())["credits"] >= 1000) {
						$this->plugin->purchasedata->setNested($player->getName().".launcher", true);
						$this->plugin->purchasedata->save();
						$this->plugin->playerdata->setNested($player->getName().".credits", $this->plugin->playerdata->get($player->getName())["credits"]-1000);
						$this->plugin->playerdata->save();
						$this->plugin::getClassManager()->setLauncherClass($player);
					} else {
						$player->sendMessage("§cYou Need §a" . (1000 - $this->plugin->playerdata->get($player->getName())["credits"]) ." §cMore Credits To Purchase This Class!");
					}
				}else{
					$this->plugin::getClassManager()->setLauncherClass($player);
				}
				break;
			case "freezer":
				if ($this->plugin->purchasedata->get($player->getName())["freeze"] == false) {
					if ($this->plugin->playerdata->get($player->getName())["credits"] >= 750) {
						$this->plugin->purchasedata->setNested($player->getName().".freeze", true);
						$this->plugin->purchasedata->save();
						$this->plugin->playerdata->setNested($player->getName().".credits", $this->plugin->playerdata->get($player->getName())["credits"]-750);
						$this->plugin->playerdata->save();
						$this->plugin::getClassManager()->setFreezerClass($player);
					} else {
						$player->sendMessage("§cYou Need §a" . (750 - $this->plugin->playerdata->get($player->getName())["credits"]) ." §cMore Credits To Purchase This Class!");
					}
				}else{
					$this->plugin::getClassManager()->setFreezerClass($player);
				}
				break;

		}
	}
}