<?php

namespace fernanACM\BetterRewards\manager;

use pocketmine\utils\Config;

use fernanACM\BetterRewards\Loader;
use fernanACM\CofreMagico\manager\types\MondayInventoryManager;

class BackupManager{

    /**
     * @return void
     */
    public static function saveAll(): void{
        self::saveMondayInventory();
    }

    /**
     * @return void
     */
    public static function saveMondayInventory(): void{
        $backup = new Config(Loader::getInstance()->getDataFolder(). "backup/mondayInv.json");
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