<?php
namespace soup\commands;
use pocketmine\Player;
use soup\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
class EventCommand extends PluginCommand {
	private $plugin;
	public function __construct(Main $plugin) {
		parent::__construct("event", $plugin);
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if (empty($args[0])) {
			return;
		}
		switch($args[0]) {
			case "start":
				switch($args[1]) {
					case "1v1":

						break;
				}
				break;
			case "join":
				if ($this->plugin->onevsonerunning) {

				} else {
					$sender->sendMessage("§cThere Is Currently No Events Running!");
					return;
				}
				break;
		}
		return;
	}
}