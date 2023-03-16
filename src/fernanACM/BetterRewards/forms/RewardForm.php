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
                        return true;
                      }
                      // Cooldown
                      if(CooldownUtils::hasCooldown($player, self::MONDAY)){
                        $cooldoown = CooldownUtils::getRemainingTime($player, self::MONDAY);
                        $player->sendMessage(Loader::Prefix(). str_replace(["{TIME}"], [$cooldoown], Loader::getMessage($player, "Messages.you-have-cooldown")));
                        return true;
                      }
                      // Add cooldown to player
                      CooldownUtils::addCooldown($player, self::MONDAY, 86400);
                      // Receive reward
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