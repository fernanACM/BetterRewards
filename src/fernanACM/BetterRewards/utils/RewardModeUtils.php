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

use pocketmine\player\Player;

use fernanACM\BetterRewards\Loader;

use fernanACM\BetterRewards\utils\CooldownUtils;
use fernanACM\BetterRewards\utils\PluginUtils;
use fernanACM\BetterRewards\utils\RewardUtils;

use fernanACM\BetterRewards\manager\types\FridayInventoryManager;
use fernanACM\BetterRewards\manager\types\MondayInventoryManager;
use fernanACM\BetterRewards\manager\types\SaturdayInventoryManager;
use fernanACM\BetterRewards\manager\types\SundayInventoryManager;
use fernanACM\BetterRewards\manager\types\ThursdayInventoryManager;
use fernanACM\BetterRewards\manager\types\TuesdayInventoryManager;
use fernanACM\BetterRewards\manager\types\WednesdayInventoryManager;
use fernanACM\BetterRewards\manager\types\MonthlyInventoryManager;

class RewardModeUtils{
    # ====(Weekdays)====
    private const MONDAY = "Monday";
    private const TUESDAY = "Tuesday";
    private const WEDNESDAY = "Wednesday";
    private const THURSDAY = "Thursday";
    private const FRIDAY = "Friday";
    private const SATURDAY = "Saturday";
    private const SUNDAY = "Sunday";

    /**
     * That is only for Mondays
     * 
     * @param Player $player
     * @return void
     */
    public static function sendMondayInventoryCustom(Player $player): void{
        $config = Loader::getInstance()->config;
        switch($config->getNested("Settings.inventory.inventory-custom")){
            case true:
                $inventory = MondayInventoryManager::getRandomItems((int)$config->getNested("Settings.inventory.monday-items"));
                foreach($inventory as $item){
                    if(!$player->getInventory()->canAddItem($item)){
                        $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.inventory-full"));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return;
                    }
                    // Receive reward
                    $player->getInventory()->addItem($item);
                    RewardUtils::sendMondayCommandReward($player);
                    CooldownUtils::addCooldown($player, self::MONDAY, 86400);
                    $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.reward-received"));
                    PluginUtils::PlaySound($player, "random.levelup", 1, 1);
                }
            break;

            case false:
                self::sendNormalReward($player, self::MONDAY);
            break;
        }
    }

    /**
     * That is only for Tuesdays
     * 
     * @param Player $player
     * @return void
     */
    public static function sendTuesdayInventoryCustom(Player $player): void{
        $config = Loader::getInstance()->config;
        switch($config->getNested("Settings.inventory.inventory-custom")){
            case true:
                $inventory = TuesdayInventoryManager::getRandomItems((int)$config->getNested("Settings.inventory.tuesday-items"));
                foreach($inventory as $item){
                    if(!$player->getInventory()->canAddItem($item)){
                        $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.inventory-full"));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return;
                    }
                    // Receive reward
                    $player->getInventory()->addItem($item);
                    RewardUtils::sendTuesdayCommandReward($player);
                    CooldownUtils::addCooldown($player, self::TUESDAY, 86400);
                    $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.reward-received"));
                    PluginUtils::PlaySound($player, "random.levelup", 1, 1);
                }
            break;

            case false:
                self::sendNormalReward($player, self::TUESDAY);
            break;
        }
    }

    /**
     * That is only for Wednesdays
     * 
     * @param Player $player
     * @return void
     */
    public static function sendWednesdayInventoryCustom(Player $player): void{
        $config = Loader::getInstance()->config;
        switch($config->getNested("Settings.inventory.inventory-custom")){
            case true:
                $inventory = WednesdayInventoryManager::getRandomItems((int)$config->getNested("Settings.inventory.wednesday-items"));
                foreach($inventory as $item){
                    if(!$player->getInventory()->canAddItem($item)){
                        $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.inventory-full"));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return;
                    }
                    // Receive reward
                    $player->getInventory()->addItem($item);
                    RewardUtils::sendTuesdayCommandReward($player);
                    CooldownUtils::addCooldown($player, self::WEDNESDAY, 86400);
                    $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.reward-received"));
                    PluginUtils::PlaySound($player, "random.levelup", 1, 1);
                }
            break;

            case false:
                self::sendNormalReward($player, self::WEDNESDAY);
            break;
        }
    }

    /**
     * That is only for Thursdays
     * 
     * @param Player $player
     * @return void
     */
    public static function sendThursdayInventoryCustom(Player $player): void{
        $config = Loader::getInstance()->config;
        switch($config->getNested("Settings.inventory.inventory-custom")){
            case true:
                $inventory = ThursdayInventoryManager::getRandomItems((int)$config->getNested("Settings.inventory.thursdayy-items"));
                foreach($inventory as $item){
                    if(!$player->getInventory()->canAddItem($item)){
                        $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.inventory-full"));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return;
                    }
                    // Receive reward
                    $player->getInventory()->addItem($item);
                    RewardUtils::sendTuesdayCommandReward($player);
                    CooldownUtils::addCooldown($player, self::THURSDAY, 86400);
                    $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.reward-received"));
                    PluginUtils::PlaySound($player, "random.levelup", 1, 1);
                }
            break;

            case false:
                self::sendNormalReward($player, self::THURSDAY);
            break;
        }
    }

    /**
     * That is only for Fridays
     * 
     * @param Player $player
     * @return void
     */
    public static function sendFridayInventoryCustom(Player $player): void{
        $config = Loader::getInstance()->config;
        switch($config->getNested("Settings.inventory.inventory-custom")){
            case true:
                $inventory = FridayInventoryManager::getRandomItems((int)$config->getNested("Settings.inventory.friday-items"));
                foreach($inventory as $item){
                    if(!$player->getInventory()->canAddItem($item)){
                        $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.inventory-full"));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return;
                    }
                    // Receive reward
                    $player->getInventory()->addItem($item);
                    RewardUtils::sendTuesdayCommandReward($player);
                    CooldownUtils::addCooldown($player, self::FRIDAY, 86400);
                    $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.reward-received"));
                    PluginUtils::PlaySound($player, "random.levelup", 1, 1);
                }
            break;

            case false:
                self::sendNormalReward($player, self::FRIDAY);
            break;
        }
    }

    /**
     * That is only for Saturdays
     * 
     * @param Player $player
     * @return void
     */
    public static function sendSaturdayInventoryCustom(Player $player): void{
        $config = Loader::getInstance()->config;
        switch($config->getNested("Settings.inventory.inventory-custom")){
            case true:
                $inventory = SaturdayInventoryManager::getRandomItems((int)$config->getNested("Settings.inventory.saturday-items"));
                foreach($inventory as $item){
                    if(!$player->getInventory()->canAddItem($item)){
                        $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.inventory-full"));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return;
                    }
                    // Receive reward
                    $player->getInventory()->addItem($item);
                    RewardUtils::sendTuesdayCommandReward($player);
                    CooldownUtils::addCooldown($player, self::SATURDAY, 86400);
                    $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.reward-received"));
                    PluginUtils::PlaySound($player, "random.levelup", 1, 1);
                }
            break;

            case false:
                self::sendNormalReward($player, self::SATURDAY);
            break;
        }
    }

    /**
     * That is only for Sundays
     * 
     * @param Player $player
     * @return void
     */
    public static function sendSundayInventoryCustom(Player $player): void{
        $config = Loader::getInstance()->config;
        switch($config->getNested("Settings.inventory.inventory-custom")){
            case true:
                $inventory = SundayInventoryManager::getRandomItems((int)$config->getNested("Settings.inventory.sunday-items"));
                foreach($inventory as $item){
                    if(!$player->getInventory()->canAddItem($item)){
                        $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.inventory-full"));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return;
                    }
                    // Receive reward
                    $player->getInventory()->addItem($item);
                    RewardUtils::sendTuesdayCommandReward($player);
                    CooldownUtils::addCooldown($player, self::SUNDAY, 86400);
                    $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.reward-received"));
                    PluginUtils::PlaySound($player, "random.levelup", 1, 1);
                }
            break;

            case false:
                self::sendNormalReward($player, self::SUNDAY);
            break;
        }
    }

    /**
     * @param Player $player
     * @param string $id
     * @return void
     */
    public static function sendNormalReward(Player $player, string $id): void{
        $item = RewardUtils::sendWeeklytems();
        if(!$player->getInventory()->canAddItem($item)){
            $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.inventory-full"));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            return;
        }
        $player->getInventory()->addItem($item);
        RewardUtils::sendMondayCommandReward($player);
        CooldownUtils::addCooldown($player, $id, 86400);
        $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.reward-received"));
        PluginUtils::PlaySound($player, "random.levelup", 1, 1);
    }
}