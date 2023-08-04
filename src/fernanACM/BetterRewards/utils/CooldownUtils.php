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

use fernanACM\BetterRewards\BetterRewards as Loader;
use fernanACM\BetterRewards\provider\ProviderManager;

class CooldownUtils{

    /**
     * @param Player $player
     * @param string $id
     * @param int $duration
     */
    public static function addCooldown(Player $player, string $id, int $duration): void{
        $expirationTime = time() + $duration;
        ProviderManager::getInstance()->addCooldown($player->getName(), $id, $expirationTime);
    }

    /**
     * @param Player $player
     * @param string $id
     */
    public static function removeCooldown(Player $player, string $id): void{
        ProviderManager::getInstance()->removeCooldown($player->getName(), $id);
    }

    /**
     * @param Player $player
     * @param string $id
     * @return bool
     */
    public static function hasCooldown(Player $player, string $id): bool{
        return ProviderManager::getInstance()->hasCooldown($player->getName(), $id);
    }

    /**
     * @param Player $player
     * @param string $id
     * @return string|null
     */
    public static function getRemainingTime(Player $player, string $id): ?string{
        $config = Loader::getInstance()->config;
        if(!self::hasCooldown($player, $id)){
            return null;
        }
    
        $cooldownData = ProviderManager::getInstance()->getCooldownData($player->getName(), $id);
        if(is_null($cooldownData)){
            return null;
        }
    
        $expiration = $cooldownData["expiration"];
        $secondsLeft = $expiration - time();
        if($secondsLeft <= 0){
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
            $output .= $time." ";
        }
        if($months > 0){
            $time = str_replace(["{MONTH}"], [$months], $config->getNested("TimeMode.months"));
            $output .= $time." ";
        }
        if($days > 0){
            $time = str_replace(["{DAY}"], [$days], $config->getNested("TimeMode.days"));
            $output .= $time." ";
        }
        if($hours > 0){
            $time = str_replace(["{HOUR}"], [$hours], $config->getNested("TimeMode.hours"));
            $output .= $time." ";
        }
        if($minutes > 0) {
            $time = str_replace(["{MINUTE}"], [$minutes], $config->getNested("TimeMode.minutes"));
            $output .= $time." ";
        }
        if($seconds > 0){
            $time = str_replace(["{SECOND}"], [$seconds], $config->getNested("TimeMode.seconds"));
            $output .= $time." ";
        }
        return trim($output);
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
}