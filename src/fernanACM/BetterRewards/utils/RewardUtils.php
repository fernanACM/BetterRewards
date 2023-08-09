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

use pocketmine\item\VanillaItems;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\item\StringToItemParser;

use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\StringToEnchantmentParser;

use fernanACM\BetterRewards\BetterRewards as Loader;

class RewardUtils{

    # ====(DIARY)====
    /**
     * @param Player $player
     * @return void
     */
    public static function sendMondayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $commands = Loader::getInstance()->config->getNested("Reward.monday-commands");
        foreach($commands as $command){
            $command = str_replace("{PLAYER}", $player->getName(), $command);
            $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
        }
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendTuesdayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $commands = Loader::getInstance()->config->getNested("Reward.tuesday-commands");
        foreach($commands as $command){
            $command = str_replace("{PLAYER}", $player->getName(), $command);
            $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
        }
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendWednesdayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $commands = Loader::getInstance()->config->getNested("Reward.wednesday-commands");
        foreach($commands as $command){
            $command = str_replace("{PLAYER}", $player->getName(), $command);
            $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
        }

    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendThursdayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $commands = Loader::getInstance()->config->getNested("Reward.thursday-commands");
        foreach($commands as $command){
            $command = str_replace("{PLAYER}", $player->getName(), $command);
            $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
        }
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendFridayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $commands = Loader::getInstance()->config->getNested("Reward.friday-commands");
        foreach($commands as $command){
            $command = str_replace("{PLAYER}", $player->getName(), $command);
            $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
        }
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendSaturdayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $commands = Loader::getInstance()->config->getNested("Reward.saturday-commands");
        foreach($commands as $command){
            $command = str_replace("{PLAYER}", $player->getName(), $command);
            $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
        }
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendSundayCommandReward(Player $player): void{
        $server = Server::getInstance();
        $commands = Loader::getInstance()->config->getNested("Reward.sunday-commands");
        foreach($commands as $command){
            $command = str_replace("{PLAYER}", $player->getName(), $command);
            $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
        }
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendWeeklyCommandReward(Player $player): void{
        $server = Server::getInstance();
        $commands = Loader::getInstance()->config->getNested("Reward.weekly-commands");
        foreach($commands as $command){
            $command = str_replace("{PLAYER}", $player->getName(), $command);
            $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
        }
    }
    # ====(MONTHLY)====
    /**
     * @param Player $player
     * @return void
     */
    public static function sendMonthlyCommandReward(Player $player): void{
        $server = Server::getInstance();
        $commands = Loader::getInstance()->config->getNested("Reward.monthly-commands");
        foreach($commands as $command){
            $command = str_replace("{PLAYER}", $player->getName(), $command);
            $server->dispatchCommand(new ConsoleCommandSender($server, $server->getLanguage()), $command);
        }
    }

    /**
     * @return array
     */
    public static function sendWeeklytems(): array{
        $config = Loader::getInstance()->config;
        $reward = $config->getNested("Reward.weekly-normal-content");
        return self::sendReward($reward);
    }

    /**
     * @return array
     */
    public static function sendMonthlyItems(): array{
        $config = Loader::getInstance()->config;
        $reward = $config->getNested("Reward.monthly-normal-content");
        return self::sendReward($reward);
    }

    /**
     * @param Player   $player
     * @param array    $allowedDays
     * @param string   $configDayPath
     * @param string   $cooldownKey
     * @param callable $callable
     * @return void
     */
    public static function getChecker(Player $player, array $allowedDays, string $configDayPath, string $cooldownKey, callable $callable): void{
        $config = Loader::getInstance()->config;
        $dayOfWeek = date("l");
        $day = $config->getNested("Days.$configDayPath");
        if(!in_array($dayOfWeek, $allowedDays)){
            $player->sendMessage(Loader::Prefix(). str_replace(["{DAY}"], [$day], Loader::getMessage($player, "Messages.the-day-does-not-correspond")));
            PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
            $callable(true);
            return;
        }
        CooldownUtils::hasCooldown($player, $cooldownKey, function (bool $result) use ($player, $cooldownKey, $callable){
            $callable($result);
            if ($result) {
                 CooldownUtils::getRemainingTime($player, $cooldownKey, function (string $output) use ($player): void {
                    $player->sendMessage(Loader::Prefix(). str_replace(["{TIME}"], [$output], Loader::getMessage($player, "Messages.you-have-cooldown")));
                    PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                });
            }
        });
    }

    /**
     * @param mixed $reward
     * @return array
     */
    protected static function sendReward(mixed $reward): array{
        $itemObject = VanillaItems::AIR();
        $items = [];
        if (isset($reward["items"])) {
            foreach ($reward["items"] as $item) {
                $itemObject = StringToItemParser::getInstance()->parse($item["item"]) ?? LegacyStringToItemParser::getInstance()->parse($item["item"]);
                $itemObject->setCount((int)$item["count"] ?? 1);
                if (isset($item["name"])) {
                    $itemObject->setCustomName(TextFormat::colorize($item['name']));
                }
                if (isset($item["lore"])) {
                    $itemObject->setLore(array_map(function ($lore) {
                        return TextFormat::colorize($lore);
                    }, $item["lore"]));
                }
                if (isset($item["enchantments"])) {
                    foreach ($item["enchantments"] as $enchantmentString) {
                        $enchantExplode = explode(":", $enchantmentString);
                        $enchantId = $enchantExplode[0];
                        $enchantLevel = (int)$enchantExplode[1];
                        $enchantment = StringToEnchantmentParser::getInstance()->parse($enchantId);
                        $enchantInstance = new EnchantmentInstance($enchantment, $enchantLevel);
                        $itemObject->addEnchantment($enchantInstance);
                    }
                }
                $items[] = $itemObject;
            }
        }
        return $items;
    }
}