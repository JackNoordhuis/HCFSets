<?php

/**
 *
 * HCFSets – SetManager.php
 *
 * Copyright (C) 2016 Jack Noordhuis
 *
 * @author JackNoordhuis
 *
 */

namespace hcfsets\sets;

use hcfsets\Main;
use pocketmine\permission\Permission;
use pocketmine\Player;

class SetManager {

	/** Configuration file name for sets */
	const SET_CONFIG_FILE = "sets.json";

	/** @var Main */
	private $plugin = null;

	/** @var Set[] */
	private $sets = [];

	/** @var Permission */
	private $baseSetPerm = null;

	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
		$this->baseSetPerm = $plugin->getServer()->getPluginManager()->getPermission("hcfsets.set");
		$this->loadSets();
	}

	/**
	 * @return Main
	 */
	public function getPlugin() : Main {
		return $this->plugin;
	}

	/**
	 * Attempt to find a set for a player
	 *
	 * @param Player $player
	 *
	 * @return bool|Set
	 */
	public function findValidSet(Player $player, $armor) {
		foreach($this->sets as $id => $set) {
			if($set->matchesSet($armor)) {
				if($player->hasPermission("hcfsets.set.{$id}")) {
					return $set;
				} else {
					return false;
				}
			}
		}
		return null;
	}

	public function close() {
		foreach($this->sets as $id => $set) {
			$set->close();
			unset($this->sets[$id]);
		}
		unset($this->sets, $this->plugin);
	}

	private function addSet(string $name, array $data) {
		$this->sets[$name] = new Set($this, $data);
		$this->plugin->getServer()->getPluginManager()->addPermission($perm = new Permission("hcfsets.set.{$name}", "Permission to use the {$name} set"));
		$this->baseSetPerm->getChildren()[$perm->getName()] = true;

	}

	private function loadSets() {
		$this->plugin->saveResource(self::SET_CONFIG_FILE);
		$data = json_decode(file_get_contents($this->plugin->getDataFolder() . self::SET_CONFIG_FILE), JSON_OBJECT_AS_ARRAY);
		foreach($data as $internalName => $setData) {
			$this->addSet($internalName, $setData);
		}
	}

}