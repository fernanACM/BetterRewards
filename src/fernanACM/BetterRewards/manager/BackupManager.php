<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\BetterRewards\manager;

use pocketmine\utils\Config;

use fernanACM\BetterRewards\Loader;

use fernanACM\BetterRewards\manager\types\MondayInventoryManager;
use fernanACM\BetterRewards\manager\types\TuesdayInventoryManager;

class BackupManager{

    /**
     * @return void
     */
    public static function saveInventoryAll(): void{
        MondayInventoryManager::saveMondayInventory();
        TuesdayInventoryManager::saveTuesdayInventory();
        self::saveWednesdayInventory();
        self::saveThursdayInventory();
        self::saveFridayInventory();
        self::saveSaturdayInventory();
        self::saveSundayInventory();
    }

    public static function saveWednesdayInventory(): void{
        $backup = new Config(Loader::getInstance()->getDataFolder(). "backup/wednesdayInv.json");
        $menu = MondayInventoryManager::getContents();
        $place = [];
        foreach($menu as $content => $item){
            $place[$content]["slot"] = $content;
            $place[$content]["item"] = $item->jsonSerialize();
        }
        $backup->setAll($place);
        $backup->save();
    }

    public static function saveThursdayInventory(): void{
        $backup = new Config(Loader::getInstance()->getDataFolder(). "backup/thursdayInv.json");
        $menu = MondayInventoryManager::getContents();
        $place = [];
        foreach($menu as $content => $item){
            $place[$content]["slot"] = $content;
            $place[$content]["item"] = $item->jsonSerialize();
        }
        $backup->setAll($place);
        $backup->save();
    }

    public static function saveFridayInventory(): void{
        $backup = new Config(Loader::getInstance()->getDataFolder(). "backup/fridayInv.json");
        $menu = MondayInventoryManager::getContents();
        $place = [];
        foreach($menu as $content => $item){
            $place[$content]["slot"] = $content;
            $place[$content]["item"] = $item->jsonSerialize();
        }
        $backup->setAll($place);
        $backup->save();
    }

    public static function saveSaturdayInventory(): void{
        $backup = new Config(Loader::getInstance()->getDataFolder(). "backup/saturdayInv.json");
        $menu = MondayInventoryManager::getContents();
        $place = [];
        foreach($menu as $content => $item){
            $place[$content]["slot"] = $content;
            $place[$content]["item"] = $item->jsonSerialize();
        }
        $backup->setAll($place);
        $backup->save();
    }

    public static function saveSundayInventory(): void{
        $backup = new Config(Loader::getInstance()->getDataFolder(). "backup/sundayInv.json");
        $menu = MondayInventoryManager::getContents();
        $place = [];
        foreach($menu as $content => $item){
            $place[$content]["slot"] = $content;
            $place[$content]["item"] = $item->jsonSerialize();
        }
        $backup->setAll($place);
        $backup->save();
    }
}