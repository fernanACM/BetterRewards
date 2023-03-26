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

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\utils\TextFormat;

use pocketmine\console\ConsoleCommandSender;

use pocketmine\item\Item;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\item\StringToItemParser;

use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\StringToEnchantmentParser;

use fernanACM\BetterRewards\Loader;

class RewardUtils{

    # ====(DIARY)====
    /**
     * @param Player $player
     * @return void
     */
    public static function sendMondayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $command = Loader::getInstance()->config->getNested("Reward.monday-commands");
        $command = str_replace("{PLAYER}", $player->getName(), $command);
        $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendTuesdayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $command = Loader::getInstance()->config->getNested("Reward.tuesday-commands");
        $command = str_replace("{PLAYER}", $player->getName(), $command);
        $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendWednesdayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $command = Loader::getInstance()->config->getNested("Reward.wednesday-commands");
        $command = str_replace("{PLAYER}", $player->getName(), $command);
        $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);

    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendThursdayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $command = Loader::getInstance()->config->getNested("Reward.thursday-commands");
        $command = str_replace("{PLAYER}", $player->getName(), $command);
        $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendFridayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $command = Loader::getInstance()->config->getNested("Reward.friday-commands");
        $command = str_replace("{PLAYER}", $player->getName(), $command);
        $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendSaturdayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $command = Loader::getInstance()->config->getNested("Reward.saturday-commands");
        $command = str_replace("{PLAYER}", $player->getName(), $command);
        $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendSundayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $command = Loader::getInstance()->config->getNested("Reward.sunday-commands");
        $command = str_replace("{PLAYER}", $player->getName(), $command);
        $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendWeeklyCommandReward(Player $player): void{
        $server = Server::getInstance();
        $command = Loader::getInstance()->config->getNested("Reward.weekly-commands");
        $command = str_replace("{PLAYER}", $player->getName(), $command);
        $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
    }
    # ====(MONTHLY)====
    /**
     * @param Player $player
     * @return void
     */
    public static function sendMonthlyCommandReward(Player $player): void{
        $server = Server::getInstance();
        $command = Loader::getInstance()->config->getNested("Reward.monthly-commands");
        $command = str_replace("{PLAYER}", $player->getName(), $command);
        $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
    }

    /**
     * @return Item
     */
    public static function sendWeeklytems(): Item{
        $config = Loader::getInstance()->config;
        $reward = $config->getNested("Reward.weekly-normal-content");
        if(isset($reward["items"])){
            foreach($reward["items"] as $item){
                $itemExplode = explode("/", $item["item"]);
                $itemObject = StringToItemParser::getInstance()->parse($item["item"]) ?? LegacyStringToItemParser::getInstance()->parse($item["item"]);
                $itemObject->setCount((int)$itemExplode[0] ?? 1);
            }
            if(isset($item["name"])){
                $itemObject->setCustomName(TextFormat::colorize($item['name']));
            }
            if(isset($item["lore"])){
                $itemObject->setLore(array_map(function($lore){
                  return TextFormat::colorize($lore);
                }, $item["lore"]));
            }
            if(isset($item["enchantments"])){
                foreach($item["enchantments"] as $enchantmentString) {
                  $enchantExplode = explode(":", $enchantmentString);
                  $enchantId = $enchantExplode[0];
                  $enchantLevel = (int)$enchantExplode[1];
                  $enchantment = StringToEnchantmentParser::getInstance()->parse($enchantId);
                  $enchantInstance = new EnchantmentInstance($enchantment, $enchantLevel ?? 1);
                  $itemObject->addEnchantment($enchantInstance);
                }
            }
        }
        return $itemObject;
    }

    /**
     * @return Item
     */
    public static function sendMonthlyItems(): Item{
        $config = Loader::getInstance()->config;
        $reward = $config->getNested("Reward.monthly-normal-content");
        if(isset($reward["items"])){
            foreach($reward["items"] as $item){
                $itemExplode = explode("/", $item["item"]);
                $itemObject = StringToItemParser::getInstance()->parse($item["item"]) ?? LegacyStringToItemParser::getInstance()->parse($item["item"]);
                $itemObject->setCount((int)$itemExplode[0] ?? 1);
            }
            if(isset($item["name"])){
                $itemObject->setCustomName(TextFormat::colorize($item['name']));
            }
            if(isset($item["lore"])){
                $itemObject->setLore(array_map(function($lore){
                  return TextFormat::colorize($lore);
                }, $item["lore"]));
            }
            if(isset($item["enchantments"])){
                foreach($item["enchantments"] as $enchantmentString) {
                  $enchantExplode = explode(":", $enchantmentString);
                  $enchantId = $enchantExplode[0];
                  $enchantLevel = (int)$enchantExplode[1];
                  $enchantment = StringToEnchantmentParser::getInstance()->parse($enchantId);
                  $enchantInstance = new EnchantmentInstance($enchantment, $enchantLevel ?? 1);
                  $itemObject->addEnchantment($enchantInstance);
                }
            }
        }
        return $itemObject;
    }
}