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
     * @param callable $callback
     * @return void
     */
    public static function hasCooldown(Player $player, string $id, callable $callback): void{
        ProviderManager::getInstance()->getCooldownData($player->getName(), $id, function (array $cooldownData) use ($callback): void{
            $callback(count($cooldownData) > 0);
        });
    }

    /**
     * @param Player   $player
     * @param string   $id
     * @param callable $callable
     * @return void
     */
    public static function getRemainingTime(Player $player, string $id, callable $callable): void{
        $config = Loader::getInstance()->config;
        ProviderManager::getInstance()->getCooldownData($player->getName(), $id, function (array $cooldownDatas) use ($player, $id, $config, $callable): void{
            if(empty($cooldownDatas)){
                return;
            }

            foreach($cooldownDatas as $cooldownData){
                $expiration = $cooldownData["expiration"];
                $secondsLeft = $expiration - time();
                if($secondsLeft <= 0){
                    self::removeCooldown($player, $id);
                    return;
                }

                $years = floor($secondsLeft / (365*24*60*60));
                $months = floor($secondsLeft / (30*24*60*60));
                $days = floor(($secondsLeft - $months*30*24*60*60) / (24*60*60));
                $hours = floor(($secondsLeft - $months*30*24*60*60 - $days*24*60*60) / (60*60));
                $minutes = floor(($secondsLeft - $months*30*24*60*60 - $days*24*60*60 - $hours*60*60) / 60);
                $seconds = $secondsLeft - $months*30*24*60*60 - $days*24*60*60 - $hours*60*60 - $minutes*60;
                $output = self::formatTimeComponent($years, 'YEAR', $config->getNested("TimeMode.years"));
                $output .= self::formatTimeComponent($months, 'MONTH', $config->getNested("TimeMode.months"));
                $output .= self::formatTimeComponent($days, 'DAY', $config->getNested("TimeMode.days"));
                $output .= self::formatTimeComponent($hours, 'HOUR', $config->getNested("TimeMode.hours"));
                $output .= self::formatTimeComponent($minutes, 'MINUTE', $config->getNested("TimeMode.minutes"));
                $output .= self::formatTimeComponent($seconds, 'SECOND', $config->getNested("TimeMode.seconds"));
                $callable(trim($output));
            }
        });
    }

    /**
     * @param Player $player
     * @param string $id
     * @return void
     */
    public static function cancelCooldown(Player $player, string $id): void{
        ProviderManager::getInstance()->getProvider()->getCooldownData($player->getName(), $id, function (array $cooldownData) use ($player, $id): void{
            if(count($cooldownData) > 0){
                self::removeCooldown($player, $id);
            }
        });
    }

    /**
     * @param float $value
     * @param string $unit
     * @param string $message
     * @return string
     */
    protected static function formatTimeComponent(float $value, string $unit, string $message): string{
        if($value > 0){
            $time = str_replace("{{$unit}}", strval($value), $message);
            return "$time ";
        }
        return '';
    }
}