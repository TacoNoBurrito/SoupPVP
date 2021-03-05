<?php
namespace soup\tasks;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use Scoreboards\Scoreboards;
use soup\Main;

class ScoreboardTask extends Task {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function onRun(int $tick) : void {
		foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
			if (isset($this->plugin->classes[$player->getName()])) {
				if (!empty($this->plugin->playerdata->get($player->getName())["kills"])) {
					$rand = ["§r§b⚬hub.hydromc.tk", "§r§b⚬discord.gg/php"];
					$r = array_rand($rand);
					$api = Scoreboards::getInstance();
					$api->new($player, "base", "§aHydro SoupPVP");
					$api->setLine($player, 1, "§fKills: §a" . $this->plugin->playerdata->get($player->getName())["kills"]);
					$api->setLine($player, 2, "§fDeaths: §a" . $this->plugin->playerdata->get($player->getName())["deaths"]);
					$api->setLine($player, 3, "§fClass: §a" . $this->plugin->classes[$player->getName()]);
					$api->setLine($player, 4, "§fCredits: §a" . $this->plugin->playerdata->get($player->getName())["credits"]);
					$api->setLine($player, 5, "§fKillStreak: §a" . $this->plugin->playerdata->get($player->getName())["killstreak"]);
					$api->setLine($player, 6, $rand[$r]);
				}
			}
		}
	}
}