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
use fernanACM\BetterRewards\utils\RewardUtils;

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
                      // Add cooldown to player
                    if($config->getNested("Settings.inventory.inventory-custom")){
                        $inventory = MondayInventoryManager::getRandomItems((int)$config->getNested("Settings.inventory.monday-items"));
                        foreach($inventory as $item){
                            if(!$player->getInventory()->canAddItem($item)){
                                $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.inventory-full"));
                                PluginUtils::PlaySound($player, "mob.villager.no", 1, 1);
                                return true;
                            }
                            // Receive reward
                            $player->getInventory()->addItem($item);
                            RewardUtils::sendMondayCommandReward($player);
                            CooldownUtils::addCooldown($player, self::MONDAY, 86400);
                            $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.reward-received"));
                            PluginUtils::PlaySound($player, "random.levelup", 1, 1);
                        }
                    }else{
                        // Receive reward
                        RewardUtils::sendMondayCommandReward($player);
                        CooldownUtils::addCooldown($player, self::MONDAY, 86400);
                        $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.reward-received"));
                        PluginUtils::PlaySound($player, "random.levelup", 1, 1);
                    }
                break;

                case 1: // Tuesday
                break;

                case 2: // Wednesday
                break;

                case 3: // Thursday
                break;

                case 4: // Friday
                break;

                case 5: // Saturday
                break;

                case 6: // Sunday
                break;

                case 7: // close
                break;
            }
        });
    }
}