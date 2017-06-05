<?php

/**
 *
 * HCFSets – Main.php
 *
 * Copyright (C) 2016 Jack Noordhuis
 *
 * @author JackNoordhuis
 *
 */

namespace hcfsets;

use hcfsets\session\SessionManager;
use hcfsets\sets\SetManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase {

	/* Settings file name/path */
	const SETTINGS_FILE = "Settings.yml";

	/* Readme file name/path */
	const README_FILE = "Readme.md";

	/** @var Config */
	private $settings = null;

	/** @var SessionManager */
	private $sessionManager = null;

	/** @var SetManager */
	private $setManager = null;

	/** @var EventListener */
	private $listener = null;

	public function onEnable() {
		$this->loadConfigs();
		$this->setSessionManager();
		$this->setSetManager();
		$this->setListener();
	}

	public function onDisable() {
		$this->listener->close();
	}

	public function getSessionManager() : SessionManager {
		return $this->sessionManager;
	}

	public function getSetManager() : SetManager {
		return $this->setManager;
	}

	public function getListener() : EventListener {
		return $this->listener;
	}

	private function loadConfigs() {
		$this->saveResource(self::README_FILE);
		$this->saveResource(self::SETTINGS_FILE);
		$this->settings = new Config($this->getDataFolder() . self::SETTINGS_FILE, Config::YAML);
	}
	/**
	 * Set the session manager
	 */
	private function setSessionManager() {
		$this->sessionManager = new SessionManager($this);
	}

	/**
	 * Set the set manager
	 */
	private function setSetManager() {
		$this->setManager = new SetManager($this);
	}

	/**
	 * Set the event listener
	 */
	private function setListener() {
		$this->listener = new EventListener($this);
	}

}