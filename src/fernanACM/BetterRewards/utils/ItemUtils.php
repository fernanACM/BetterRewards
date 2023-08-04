<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

declare(strict_types=1);

namespace fernanACM\BetterRewards\utils;

use pocketmine\item\Item;

class ItemUtils{

    /**
     * @param Item $item
     * @return string
     */
    public static function encodeItem(Item $item): string{
        $itemToJson = self::itemToJson($item);
        return base64_encode(gzcompress($itemToJson));
    }

    /**
     * @param string $item
     * @return Item
     */
    public static function decodeItem(string $item): Item{
        $itemFromJson = gzuncompress(base64_decode($item));
        return self::jsonToItem($itemFromJson);
    }

    /**
     * @param Item $item
     * @return string
     */
    public static function itemToJson(Item $item): string{
        $cloneItem = clone $item;
        $itemNBT = $cloneItem->nbtSerialize();
        return base64_encode(serialize($itemNBT));
    }

    /**
     * @param string $json
     * @return Item
     */
    public static function jsonToItem(string $json): Item{
        $itemNBT = unserialize(base64_decode($json));
        return Item::nbtDeserialize($itemNBT);
    }
}