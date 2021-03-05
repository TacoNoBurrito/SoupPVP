<?php
namespace soup\tasks;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use soup\Main;
class AnnouncementTask extends Task {
	private $plugin;
	private $count = 0;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function onRun(int $currentTick) : void {
		$this->count++;
		$message1 = [
			"   \n§bAnnouncement!\n",
			"   §bYou Can Join The Discord At §ediscord.gg/php§b!\n"
		];
		$message2 = [
			"   \n§bAnnouncement!\n",
			"   §bYou Can Buy Perks, Ranks, Cosmetics And More At §ehydrohcfw.tebex.io§b!\n"
		];
		$message3 = [
			"   \n§bAnnouncement!\n",
			"   §eKill §bPlayers To Earn §eCredits §bAnd Buy More §eClasses §bTo Pvp With!\n"
		];
		$array = [$message1, $message2, $message3];
		$rand = array_rand($array);
		if ($this->count > 120) {
			foreach($array[$rand] as $message) {
				$this->plugin->getServer()->broadcastMessage($message);
			}
			$this->count = 0;
		}

	}
}