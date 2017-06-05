HCFSets
===================
__PocketMine Plugin__


### About
Beginnings of a HCF (hardcore factions) sets plugin. This was originally a commission but it fell through and I decided to open source the code.


__The content of this repo is licensed under the GNU Lesser General Public License v2.1. A full copy of the license is
available [here](LICENSE).__


## Display
The display attribute of a set is the display name that will be used in messages.


## Armor
The armor attribute of a set is used to define what armor a player needs to be wearing to activate the set.

### There are four sub-attributes fo armor:
* Helmet
* Chestplate
* Leggings
* Boots

#### Each sub-attribute requires two parameters:
* __id –__ The ID of the item
* __allows-enchantments –__ Whether the item can be enchanted or not (if false the armor cannot be enchanted)

*__Example:__*
```json
    "armor": {
      "helmet": {
        "id": "golden_helmet",
        "allows-enchantments": false
      },
      "chestplate": {
        "id": "golden_chestplate",
        "allows-enchantments": false
      },
      "leggings": {
        "id": "golden_leggings",
        "allows-enchantments": false
      },
      "boots": {
        "id": "golden_leggings",
        "allows-enchantments": false
      }
    }
```


## Buffs
The buffs attribute of a set is used to define which permanent effects a player will have when they are wearing a set.

#### Each buff requires two parameters
* __id –__ ID of the effect
* __amplifier –__ Amplifier of the effect

*__Example:__*
```json
    "buffs": [
      {
        "id": "jump_boost",
        "amplifier": 1
      },
      {
        "id": "swiftness",
        "amplifier": 0
      }
    ]
```


## Held item buffs
The held item buffs attribute is used to define which items will grant an effect to a player an their nearby faction members.

### Each item creates its own sub-attribute
Every item that has a held item buff can have multiple effects so each item is a sub-attribute.

#### Each item sub-attribute requires two parameters
* __id –__ ID of the effect
* __amplifier –__ Amplifier of the effect

*__Example:__*
```json
    "held-item-buffs": {
      "magma_cream": [
        {
          "id": "fire_resistance",
          "amplifier": 0
        }
      ],
      "blaze_rod": [
        {
          "id": "strength",
          "amplifier": 0
        }
      ]
    }
```

*__Multiple Effects:__*

```json
    "held-item-buffs": {
      "redstone": [
        {
          "id": "fire_resistance",
          "amplifier": 0
        },
        {
          "id": "strength",
          "amplifier": 0
        }
      ],
      "emerald": [
        {
          "id": "regeneration",
          "amplifier": 0
        },
        {
          "id": "night_vision",
          "amplifier": 0
        },
        {
          "id": "jump_boost",
          "amplifier": 0
        }
      ]
    }
```


## Item interact buffs
The item interact buffs attribute is used to define items that a player can use to apply effects to themselves, enemies and/or their faction members.

### Each item creates its own sub-attribute
Every item that has a item interact buff can have multiple effects so each item is a sub-attribute.

#### Each item sub-attribute requires two parameters
* __id –__ ID of the effect
* __amplifier –__ Amplifier of the effect
* __duration –__ Duration of the effect in seconds
* __cooldown –__ Cooldown duration in seconds
* __targets –__ Who the effects should apply to

*__Example:__*
```json
    "item-interact-buffs": {
      "sugar": [
        {
          "id": "swiftness",
          "amplifier": 2,
          "duration": 3,
          "cooldown": 300,
          "targets": [
            "faction",
            "self"
          ]
        }
      ],
      "iron": [
        {
          "id": "strength",
          "amplifier": 4,
          "duration": 5,
          "cooldown": 300,
          "targets": [
            "faction"
          ]
        }
      ]
    }
```

*__Multiple Effects:__*

```json
    "item-interact-buffs": {
      "sugar": [
        {
          "id": "swiftness",
          "amplifier": 2,
          "duration": 3,
          "cooldown": 300,
          "targets": [
            "faction",
            "self"
          ]
        },
        {
          "id": "jump_boost",
          "amplifier": 2,
          "duration": 4,
          "cooldown": 300,
          "targets": [
            "faction"
          ]
        }
      ],
      "emerald": [
        {
          "id": "regeneration",
          "amplifier": 1,
          "duration": 10,
          "cooldown": 300,
          "targets": [
            "faction"
          ]
        },
        {
          "id": "night_vision",
          "amplifier": 0,
          "duration": 60,
          "cooldown": 300,
          "targets": [
            "faction",
            "self"
          ]
        },
        {
          "id": "wither",
          "amplifier": 0,
          "duration": 12,
          "cooldown": 300,
          "targets": [
            "enemy"
          ]
        }
      ]
    }
```