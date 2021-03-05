<?php
namespace soup\ui;

use soup\Main;
use soup\ui\form\FormUIs;
use soup\ui\inventory\InventoryUIs;

class UIManager {
	private $plugin;
	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
	}
	public function openUi($player, $type) {
		switch($type) {
			case "classes":
				if ($this->plugin::getUtils()->isWin10($player)) {
					$file = new InventoryUIs($this->plugin);
					$file->openShopForm($player);
				} else {
					$file = new FormUIs($this->plugin);
					$file->openShopForm($player);
				}
				break;
			case "perks":

				break;
			case "stats":

				break;
		}
	}
}