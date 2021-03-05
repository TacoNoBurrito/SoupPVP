<?php
namespace soup\anticheat;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\Player;
use soup\Main;

class AnticheatListener implements Listener {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function onDamage(EntityDamageEvent $event) : void {
		/**
		if ($event instanceof EntityDamageByEntityEvent) {
			$player = $event->getEntity();
			$damager = $event->getDamager();
			if ($player instanceof Player and $damager instanceof Player) {
				if ($player->distance($damager) > 6.5) {
					if ($damager->getPing() > 120) {
						$this->plugin->sendMessageToStaff("§cAC: §a".$damager->getName()." Is Possible Using Reach Hacks, Please Check Them Out.");
						return;
					}
					$damager->kick("§cYou Have Been Banned Forever For Reach Cheats.", false);
					$damager->setBanned(true);
				} else {
					if ($player->distance($damager) >= 5.5) {
						$this->plugin->sendMessageToStaff("§cAC: §a".$damager->getName()." Is Possible Using Reach Hacks, Please Check Them Out.");
					}
				}
			}
		}
		 */
	}
}