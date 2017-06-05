<?php

/**
 *
 * HCFSets – EventListener.php
 *
 * Copyright (C) 2016 Jack Noordhuis
 *
 * @author JackNoordhuis
 *
 */

namespace hcfsets;

use pocketmine\event\entity\EntityArmorChangeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;

class EventListener implements Listener {

	/** @var Main */
	private $plugin = null;

	/** @var bool */
	private $closed = false;

	public function __construct(Main $plugin) {
		$this->plugin = $plugin;
		$plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
	}

	/**
	 * @return Main
	 */
	public function getPlugin() : Main {
		return $this->plugin;
	}

	/**
	 * Open a session for the player
	 *
	 * @param PlayerJoinEvent $event
	 */
	public function onJoin(PlayerJoinEvent $event) {
		$this->plugin->getSessionManager()->openSession($event->getPlayer());
	}

	/**
	 * Check a players set through their session
	 *
	 * @param EntityArmorChangeEvent $event
	 */
	public function onArmorChange(EntityArmorChangeEvent $event) {
		$entity = $event->getEntity();
		if($entity instanceof Player) {
			$mngr = $this->plugin->getSessionManager();
			if($mngr->hasOpenSession($entity)) {
				$mngr->getOpenSession($entity)->checkSet($event->getNewItem());
			}
		}
	}

	public function onItemHold(PlayerItemHeldEvent $event) {

	}

	/**
	 * Close the quitting players session
	 *
	 * @param PlayerQuitEvent $event
	 */
	public function onQuit(PlayerQuitEvent $event) {
		$this->getPlugin()->getSessionManager()->closeSession($event->getPlayer());
	}

	/**
	 * Make sure the object is destroyed safely
	 */
	public function close() {
		if(!$this->closed) {
			$this->closed = true;
			unset($this->plugin);
		}
	}

	public function __destruct() {
		$this->close();
	}

}