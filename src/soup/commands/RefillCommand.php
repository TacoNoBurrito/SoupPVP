<?php
namespace soup\commands;
use muqsit\invmenu\InvMenu;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\Player;
use soup\Main;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
class RefillCommand extends PluginCommand {
	private $plugin;
	public function __construct(Main $plugin) {
		parent::__construct("refill", $plugin);
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		$menu = InvMenu::create(InvMenu::TYPE_CHEST);
		$menu->setName("Refill Menu");
		$inventory = $menu->getInventory();
		$inventory->addItem(Item::get(ItemIds::MUSHROOM_STEW, 0, 35));
		$menu->send($sender);
	}
}