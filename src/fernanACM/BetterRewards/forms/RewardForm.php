<?php

#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\BetterRewards\forms;

use DateTime;
use pocketmine\player\Player;

use Vecnavium\FormsUI\SimpleForm;

use fernanACM\BetterRewards\Loader;

use fernanACM\BetterRewards\utils\CooldownUtils;
use fernanACM\BetterRewards\utils\PluginUtils;
use fernanACM\BetterRewards\utils\RewardModeUtils;

use fernanACM\BetterRewards\manager\types\FridayInventoryManager;
use fernanACM\BetterRewards\manager\types\MondayInventoryManager;
use fernanACM\BetterRewards\manager\types\MonthlyInventoryManager;
use fernanACM\BetterRewards\manager\types\SaturdayInventoryManager;
use fernanACM\BetterRewards\manager\types\SundayInventoryManager;
use fernanACM\BetterRewards\manager\types\ThursdayInventoryManager;
use fernanACM\BetterRewards\manager\types\TuesdayInventoryManager;
use fernanACM\BetterRewards\manager\types\WednesdayInventoryManager;

class RewardForm{

    # ====(Weekdays)====
    private const MONDAY = "Monday";
    private const TUESDAY = "Tuesday";
    private const WEDNESDAY = "Wednesday";
    private const THURSDAY = "Thursday";
    private const FRIDAY = "Friday";
    private const SATURDAY = "Saturday";
    private const SUNDAY = "Sunday";

    /**
     * @param Player $player
     * @return void
     */
    public static function getRewardDiary(Player $player): void{
        $now = new DateTime();
        $dayOfWeek = $now->format("l");
        $config = Loader::getInstance()->config;
        $form = new SimpleForm(function(Player $player, $data) use($dayOfWeek, $config){
            if($data === null){
                return true;
            }
            switch($data){
                case 0: // Monday
                    $allowedDays = ["Monday"];
                    $day = $config->getNested("Days.monday");
                    if(!in_array($dayOfWeek, $allowedDays)){
                        $player->sendMessage(Loader::Prefix(). str_replace(["{DAY}"], [$day], Loader::getMessage($player, "Messages.the-day-does-not-correspond")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                      // Cooldown
                    if(CooldownUtils::hasCooldown($player, self::MONDAY)){
                        $cooldoown = CooldownUtils::getRemainingTime($player, self::MONDAY);
                        $player->sendMessage(Loader::Prefix(). str_replace(["{TIME}"], [$cooldoown], Loader::getMessage($player, "Messages.you-have-cooldown")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                    // Receive reward
                    RewardModeUtils::sendMondayInventoryCustom($player);
                break;

                case 1: // Tuesday
                    $allowedDays = ["Tuesday"];
                    $day = $config->getNested("Days.tuesday");
                    if(!in_array($dayOfWeek, $allowedDays)){
                        $player->sendMessage(Loader::Prefix(). str_replace(["{DAY}"], [$day], Loader::getMessage($player, "Messages.the-day-does-not-correspond")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                      // Cooldown
                    if(CooldownUtils::hasCooldown($player, self::TUESDAY)){
                        $cooldoown = CooldownUtils::getRemainingTime($player, self::TUESDAY);
                        $player->sendMessage(Loader::Prefix(). str_replace(["{TIME}"], [$cooldoown], Loader::getMessage($player, "Messages.you-have-cooldown")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                    // Receive reward
                    RewardModeUtils::sendTuesdayInventoryCustom($player);
                break;

                case 2: // Wednesday
                    $allowedDays = ["Wednesday"];
                    $day = $config->getNested("Days.wednesday");
                    if(!in_array($dayOfWeek, $allowedDays)){
                        $player->sendMessage(Loader::Prefix(). str_replace(["{DAY}"], [$day], Loader::getMessage($player, "Messages.the-day-does-not-correspond")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                      // Cooldown
                    if(CooldownUtils::hasCooldown($player, self::WEDNESDAY)){
                        $cooldoown = CooldownUtils::getRemainingTime($player, self::WEDNESDAY);
                        $player->sendMessage(Loader::Prefix(). str_replace(["{TIME}"], [$cooldoown], Loader::getMessage($player, "Messages.you-have-cooldown")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                    // Receive reward
                    RewardModeUtils::sendWednesdayInventoryCustom($player);
                break;

                case 3: // Thursday
                    $allowedDays = ["Thursday"];
                    $day = $config->getNested("Days.thursday");
                    if(!in_array($dayOfWeek, $allowedDays)){
                        $player->sendMessage(Loader::Prefix(). str_replace(["{DAY}"], [$day], Loader::getMessage($player, "Messages.the-day-does-not-correspond")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                      // Cooldown
                    if(CooldownUtils::hasCooldown($player, self::THURSDAY)){
                        $cooldoown = CooldownUtils::getRemainingTime($player, self::THURSDAY);
                        $player->sendMessage(Loader::Prefix(). str_replace(["{TIME}"], [$cooldoown], Loader::getMessage($player, "Messages.you-have-cooldown")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                    // Receive reward
                    RewardModeUtils::sendThursdayInventoryCustom($player);
                break;

                case 4: // Friday
                    $allowedDays = ["Friday"];
                    $day = $config->getNested("Days.friday");
                    if(!in_array($dayOfWeek, $allowedDays)){
                        $player->sendMessage(Loader::Prefix(). str_replace(["{DAY}"], [$day], Loader::getMessage($player, "Messages.the-day-does-not-correspond")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                      // Cooldown
                    if(CooldownUtils::hasCooldown($player, self::FRIDAY)){
                        $cooldoown = CooldownUtils::getRemainingTime($player, self::FRIDAY);
                        $player->sendMessage(Loader::Prefix(). str_replace(["{TIME}"], [$cooldoown], Loader::getMessage($player, "Messages.you-have-cooldown")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                    // Receive reward
                    RewardModeUtils::sendFridayInventoryCustom($player);
                break;

                case 5: // Saturday
                    $allowedDays = ["Saturday"];
                    $day = $config->getNested("Days.saturday");
                    if(!in_array($dayOfWeek, $allowedDays)){
                        $player->sendMessage(Loader::Prefix(). str_replace(["{DAY}"], [$day], Loader::getMessage($player, "Messages.the-day-does-not-correspond")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                      // Cooldown
                    if(CooldownUtils::hasCooldown($player, self::SATURDAY)){
                        $cooldoown = CooldownUtils::getRemainingTime($player, self::SATURDAY);
                        $player->sendMessage(Loader::Prefix(). str_replace(["{TIME}"], [$cooldoown], Loader::getMessage($player, "Messages.you-have-cooldown")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                    // Receive reward
                    RewardModeUtils::sendSaturdayInventoryCustom($player);
                break;

                case 6: // Sunday
                    $allowedDays = ["Sunday"];
                    $day = $config->getNested("Days.sunday");
                    if(!in_array($dayOfWeek, $allowedDays)){
                        $player->sendMessage(Loader::Prefix(). str_replace(["{DAY}"], [$day], Loader::getMessage($player, "Messages.the-day-does-not-correspond")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                      // Cooldown
                    if(CooldownUtils::hasCooldown($player, self::SUNDAY)){
                        $cooldoown = CooldownUtils::getRemainingTime($player, self::SUNDAY);
                        $player->sendMessage(Loader::Prefix(). str_replace(["{TIME}"], [$cooldoown], Loader::getMessage($player, "Messages.you-have-cooldown")));
                        PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                        return true;
                    }
                    // Receive reward
                    RewardModeUtils::sendSundayInventoryCustom($player);
                break;

                case 7: // close
                break;
            }
        });
    }
}