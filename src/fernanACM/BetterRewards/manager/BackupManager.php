<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\BetterRewards\manager;

use fernanACM\BetterRewards\manager\types\FridayInventoryManager;
use fernanACM\BetterRewards\manager\types\MondayInventoryManager;
use fernanACM\BetterRewards\manager\types\MonthlyInventoryManager;
use fernanACM\BetterRewards\manager\types\SaturdayInventoryManager;
use fernanACM\BetterRewards\manager\types\SundayInventoryManager;
use fernanACM\BetterRewards\manager\types\ThursdayInventoryManager;
use fernanACM\BetterRewards\manager\types\TuesdayInventoryManager;
use fernanACM\BetterRewards\manager\types\WednesdayInventoryManager;

class BackupManager{

    /**
     * @return void
     */
    public static function saveInventoryAll(): void{
        MondayInventoryManager::saveInventory();
        TuesdayInventoryManager::saveInventory();
        WednesdayInventoryManager::saveInventory();
        ThursdayInventoryManager::saveInventory();
        FridayInventoryManager::saveInventory();
        SaturdayInventoryManager::saveInventory();
        SundayInventoryManager::saveInventory();
        MonthlyInventoryManager::saveInventory();
    }

    /**
     * @return void
     */
    public static function loadInventoryAll(): void{
        MondayInventoryManager::loadInventory();
        TuesdayInventoryManager::loadInventory();
        WednesdayInventoryManager::loadInventory();
        ThursdayInventoryManager::loadInventory();
        FridayInventoryManager::loadInventory();
        SaturdayInventoryManager::loadInventory();
        SundayInventoryManager::loadInventory();
        MonthlyInventoryManager::loadInventory();
    }
}