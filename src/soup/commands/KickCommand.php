<?php
namespace soup\commands;
use pocketmine\Player;
use soup\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
class KickCommand extends PluginCommand {
	private $plugin;
	public function __construct(Main $plugin) {
		parent::__construct("kick", $plugin);
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		$array = ["manager","mod","owner"];
		if (in_array($this->plugin->playerdata->get($sender->getName())["rank"], $array)) {
			if (empty($args[0])){
				return;
			}
			$pl = $this->plugin->getServer()->getPlayer($args[0]);
			if ($pl == null) return;
			unset($args[0]);
			$reason = implode(" ", $args);
			if (empty($reason)) {
				$reason = "Unidentified";
			}
			$pl->kick("§bYou Have Just Been Kicked From SoupPVP\nReason: ".$reason);
			$message = [
				"    \n§bThe Player §e".$pl->getName()."§b Has Been Removed From The Game!\n",
				"    §bReason: §c".$reason."\n"
			];
			foreach($message as $msg) {
				$this->plugin->getServer()->broadcastMessage($msg);
			}
		}
		return;
	}
}