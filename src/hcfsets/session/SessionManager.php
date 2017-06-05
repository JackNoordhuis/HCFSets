<?php

/**
 *
 * HCFSets – SessionManager.php
 *
 * Copyright (C) 2016 Jack Noordhuis
 *
 * @author JackNoordhuis
 *
 */

namespace hcfsets\session;

use hcfsets\Main;
use pocketmine\Player;
use pocketmine\scheduler\PluginTask;

class SessionManager {

	/** @var Main */
	private $plugin;

	private $sessionHeartbeat = null;

	/** @var PlayerSession[] */
	private $sessions = [];

	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
		$this->sessionHeartbeat = new class($this) extends PluginTask {

			/** @var SessionManager */
			private $manager = null;

			public function __construct(SessionManager $manager) {
				$this->manager = $manager;
				parent::__construct($manager->getPlugin());
			}

			public function onRun($currentTick) {
				$this->manager->tickSessions($currentTick);
			}
		};
		$this->plugin->getServer()->getScheduler()->scheduleRepeatingTask($this->sessionHeartbeat, 20 * 15);
	}

	public function getPlugin() : Main {
		return $this->plugin;
	}

	public function tickSessions($tick) {
		foreach($this->sessions as $hash => $session) {
			if(!$session->tick($tick)) {
				unset($this->sessions[$hash]);
			}
		}
	}

	/**
	 * @param Player $player
	 *
	 * @return PlayerSession
	 */
	public function openSession(Player $player) : PlayerSession {
		return $this->sessions[spl_object_hash($player)] = new PlayerSession($this, $player);
	}

	/**
	 * @param Player $player
	 *
	 * @return bool
	 */
	public function hasOpenSession(Player $player) : bool {
		return isset($this->sessions[spl_object_hash($player)]);
	}

	/**
	 * @param Player $player
	 *
	 * @return PlayerSession|null
	 */
	public function getOpenSession(Player $player) {
		return $this->sessions[spl_object_hash($player)] ?? null;
	}

	/**
	 * @param Player $player
	 *
	 * @return bool
	 */
	public function closeSession(Player $player) : bool {
		if(isset($this->sessions[$hash = spl_object_hash($player)])) {
			unset($this->sessions[$hash]);
			return true;
		}
		return false;
	}

}