<?php

/**
 *
 * HCFSets – ArmorSet.php
 *
 * Copyright (C) 2016 Jack Noordhuis
 *
 * @author JackNoordhuis
 *
 */

namespace hcfsets\sets;

use pocketmine\item\Item;

class ArmorSet {

	/** @var Set */
	private $set = null;

	/** @var array */
	private $rawData = [];

	/** @var \stdClass */
	private $data = null;

	/** @var bool */
	private $closed = false;

	/**
	 * ArmorSet constructor.
	 *
	 * @param Set $set
	 * @param array $data
	 */
	public function __construct(Set $set, array $data) {
		$this->set = $set;
		$this->rawData = $data;
		$this->data = new \stdClass();
		$this->data->helmet = [
			"item" => $item = Item::fromString($this->rawData["helmet"]["id"]),
			"id" => $item->getId(),
			"allows-enchants" => (bool) $this->rawData["helmet"]["allows-enchantments"],
		];
		$this->data->chestplate = [
			"item" => $item = Item::fromString($this->rawData["chestplate"]["id"]),
			"id" => $item->getId(),
			"allows-enchants" => (bool) $this->rawData["chestplate"]["allows-enchantments"],
		];
		$this->data->leggings = [
			"item" => $item = Item::fromString($this->rawData["leggings"]["id"]),
			"id" => $item->getId(),
			"allows-enchants" => (bool) $this->rawData["leggings"]["allows-enchantments"],
		];
		$this->data->boots = [
			"item" => $item = Item::fromString($this->rawData["boots"]["id"]),
			"id" => $item->getId(),
			"allows-enchants" => (bool) $this->rawData["boots"]["allows-enchantments"],
		];
	}

	public function getSet() : Set {
		return $this->set;
	}

	/**
	 * Check if an item matches the armor sets helmet
	 *
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function isValidHelmet(Item $item) : bool {
		return $this->getHelmetId() === $item->getId() and ($this->helmetAllowsEnchantments() ? true : !$item->hasEnchantments());
	}

	public function getHelmet() : Item {
		return clone $this->data->helmet["item"];
	}

	public function getHelmetId() : int {
		return $this->data->helmet["id"];
	}

	public function helmetAllowsEnchantments() : bool {
		return $this->data->helmet["allows-enchants"];
	}

	/**
	 * Check if an item matches the armor sets chestplate
	 *
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function isValidChestplate(Item $item) : bool {
		return $this->getChestplateId() === $item->getId() and ($this->chestplateAllowsEnchantments() ? true : !$item->hasEnchantments());
	}

	public function getChestplate() : Item {
		return clone $this->data->chestplate["item"];
	}

	public function getChestplateId() : int {
		return $this->data->chestplate["id"];
	}

	public function chestplateAllowsEnchantments() : bool {
		return $this->data->chestplate["allows-enchants"];
	}

	/**
	 * Check if an item matches the armor sets leggings
	 *
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function isValidLeggings(Item $item) : bool {
		return $this->getLeggingsId() === $item->getId() and ($this->leggingsAllowsEnchantments() ? true : !$item->hasEnchantments());
	}

	public function getLeggings() : Item {
		return clone $this->data->leggings["item"];
	}

	public function getLeggingsId() : int {
		return $this->data->leggings["id"];
	}

	public function leggingsAllowsEnchantments() : bool {
		return $this->data->leggings["allows-enchants"];
	}

	/**
	 * Check if an item matches the armor sets boots
	 *
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function isValidBoots(Item $item) : bool {
		return $this->getBootsId() === $item->getId() and ($this->bootsAllowsEnchantments() ? true : !$item->hasEnchantments());
	}

	public function getBoots() : Item {
		return clone $this->data->boots["item"];
	}

	public function getBootsId() : int {
		return $this->data->boots["id"];
	}

	public function bootsAllowsEnchantments() : bool {
		return $this->data->boots["allows-enchants"];
	}

	public function close() {
		if(!$this->closed) {
			$this->closed = true;
			unset($this->set, $this->rawData, $this->data);
		}
	}

	public function __destruct() {
		$this->close();
	}

}