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

class CooldownUtils {

    /** @var array<string, array{timestamp: int, duration: int}> */
    private static $cooldowns = [];

    /**
     * @param Player $player
     * @param string $id
     * @param int $duration
     */
    public static function addCooldown(Player $player, string $id, int $duration): void{
        self::$cooldowns[$player->getName()][$id] = [
            "timestamp" => time(),
            "duration" => $duration
        ];
        self::saveCooldownsToFile();
    }

    /**
     * @param Player $player
     * @param string $id
     */
    public static function removeCooldown(Player $player, string $id): void{
        unset(self::$cooldowns[$player->getName()][$id]);
        if(empty(self::$cooldowns[$player->getName()])){
            unset(self::$cooldowns[$player->getName()]);
            self::saveCooldownsToFile();
        }
    }

    /**
     * @param Player $player
     * @param string $id
     * @return bool
     */
    public static function hasCooldown(Player $player, string $id): bool{
        return isset(self::$cooldowns[$player->getName()][$id]);
    }

    /**
     * @param Player $player
     * @param string $id
     * @return string|null
     */
    public static function getRemainingTime(Player $player, string $id): ?string{
        $config = Loader::getInstance()->getConfig();
    
        if(!self::hasCooldown($player, $id)){
            return null;
        }
    
        $cooldownData = self::$cooldowns[$player->getName()][$id];
        $cooldownEnd = $cooldownData["timestamp"] + $cooldownData["duration"];
    
        $secondsLeft = $cooldownEnd - time();
        if ($secondsLeft <= 0) {
            self::removeCooldown($player, $id);
            return null;
        }
    
        $years = floor($secondsLeft / (365*24*60*60));
        $months = floor($secondsLeft / (30*24*60*60));
        $days = floor(($secondsLeft - $months*30*24*60*60) / (24*60*60));
        $hours = floor(($secondsLeft - $months*30*24*60*60 - $days*24*60*60) / (60*60));
        $minutes = floor(($secondsLeft - $months*30*24*60*60 - $days*24*60*60 - $hours*60*60) / 60);
        $seconds = $secondsLeft - $months*30*24*60*60 - $days*24*60*60 - $hours*60*60 - $minutes*60;
        $output = "";
        if($years > 0){
            $time = str_replace(["{YEAR}"], [$years], $config->getNested("TimeMode.years"));
            $output .= $time."\n";
        }
        if($months > 0){
            $time = str_replace(["{MONTH}"], [$months], $config->getNested("TimeMode.months"));
            $output .= $time."\n";
        }
        if($days > 0){
            $time = str_replace(["{DAY}"], [$days], $config->getNested("TimeMode.days"));
            $output .= $time."\n";
        }
        if($hours > 0){
            $time = str_replace(["{HOUR}"], [$hours], $config->getNested("TimeMode.hours"));
            $output .= $time."\n";
        }
        if($minutes > 0) {
            $time = str_replace(["{MINUTE}"], [$minutes], $config->getNested("TimeMode.minutes"));
            $output .= $time."\n";
        }
        if($seconds > 0){
            $time = str_replace(["{SECOND}"], [$seconds], $config->getNested("TimeMode.seconds"));
            $output .= $time."\n";
        }
        return trim($output);
    }    

    /**
     * @param Player $player
     * @param string $id
     * @return void
     */
    public static function startCooldown(Player $player, string $id): void{
        self::$cooldowns[$player->getName()][$id] = [
            "timestamp" => time(),
            "duration" => 0
       ];
       self::saveCooldownsToFile();
    }

    /**
     * @param Player $player
     * @param string $id
     * @return void
     */
    public static function cancelCooldown(Player $player, string $id): void{
        if(self::hasCooldown($player, $id)){
            self::removeCooldown($player, $id);
        }
    }

    /**
     * @return void
     */
    public static function saveCooldownsToFile(): void{
        $cooldownData = json_encode(self::$cooldowns);
        file_put_contents(Loader::getInstance()->getDataFolder() . "cooldowns.json", $cooldownData);
    }

    /**
     * @return void
     */
    public static function loadCooldownsFromFile(): void{
        $fileData = file_get_contents(Loader::getInstance()->getDataFolder() . "cooldowns.json");
        $cooldownData = json_decode($fileData, true);
        if(is_array($cooldownData)){
            self::$cooldowns = $cooldownData;
        }
    }
}

