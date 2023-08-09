<?php

#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\BetterRewards\forms;

use pocketmine\player\Player;

use Vecnavium\FormsUI\SimpleForm;

use fernanACM\BetterRewards\BetterRewards as Loader;

use fernanACM\BetterRewards\utils\CooldownUtils;
use fernanACM\BetterRewards\utils\PluginUtils;
use fernanACM\BetterRewards\utils\RewardModeUtils;
use fernanACM\BetterRewards\utils\RewardUtils;

class RewardForm{

    # ====(Weekdays)====
    private const MONDAY = "Monday";
    private const TUESDAY = "Tuesday";
    private const WEDNESDAY = "Wednesday";
    private const THURSDAY = "Thursday";
    private const FRIDAY = "Friday";
    private const SATURDAY = "Saturday";
    private const SUNDAY = "Sunday";
    # ====(Monthly)====
    private const MONTHLY = "Monthly";

    /**
     * @param Player $player
     * @return void
     */
    public static function getRewardsForm(Player $player): void{
        $form = new SimpleForm(function(Player $player, $data){
            if($data === null){
                return;
            }
            switch($data){
                case 0: // Diary
                    RewardForm::getRewardDiary($player);
                    PluginUtils::PlaySound($player, "random.pop", 1, 5.5);
                break;

                case 1: // Monthly
                    RewardForm::getRewardMonthly($player);
                    PluginUtils::PlaySound($player, "random.pop", 1, 5.5);
                break;

                case 2:
                    PluginUtils::PlaySound($player, "random.pop2", 1, 2.8);
                break;
            }
        });
        $form->setTitle(Loader::getMessage($player, "RewardForm.General.title"));
        $form->setContent(Loader::getMessage($player, "RewardForm.General.content"));
        $form->addButton(Loader::getMessage($player, "RewardForm.General.button-diary"),1,"https://i.imgur.com/asijTJl.png");
        $form->addButton(Loader::getMessage($player, "RewardForm.General.button-monthly"),1,"https://i.imgur.com/E86x54W.png");
        $form->addButton(Loader::getMessage($player, "RewardForm.General.button-close"),0,"textures/ui/cancel");
        $player->sendForm($form);
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function getRewardDiary(Player $player): void{
        $form = new SimpleForm(function(Player $player, $data){
            if(is_null($data)){
                return;
            }
            switch($data){
                case 0: // Monday
                    $allowedDays = ["Monday"];
                    $day = strtolower(self::MONDAY);
                    RewardUtils::getChecker($player, $allowedDays, $day, self::MONDAY, function (bool $result) use ($player): void {
                        if($result){
                            return;
                        }
                        // Receive reward
                        RewardModeUtils::sendMondayInventoryCustom($player);
                    });
                break;

                case 1: // Tuesday
                    $allowedDays = ["Tuesday"];
                    $day = strtolower(self::TUESDAY);
                    RewardUtils::getChecker($player, $allowedDays, $day, self::TUESDAY, function (bool $result) use ($player): void {
                        if($result){
                            return;
                        }
                        // Receive reward
                        RewardModeUtils::sendTuesdayInventoryCustom($player);
                    });
                break;

                case 2: // Wednesday
                    $allowedDays = ["Wednesday"];
                    $day = strtolower(self::WEDNESDAY);
                    RewardUtils::getChecker($player, $allowedDays, $day, self::WEDNESDAY, function (bool $result) use ($player): void {
                        if($result){
                            return;
                        }
                        // Receive reward
                        RewardModeUtils::sendWednesdayInventoryCustom($player);
                    });
                break;

                case 3: // Thursday
                    $allowedDays = ["Thursday"];
                    $day = strtolower(self::THURSDAY);
                    RewardUtils::getChecker($player, $allowedDays, $day, self::THURSDAY, function (bool $result) use ($player): void {
                        if($result){
                            return;
                        }
                        // Receive reward
                        RewardModeUtils::sendThursdayInventoryCustom($player);
                    });
                break;

                case 4: // Friday
                    $allowedDays = ["Friday"];
                    $day = strtolower(self::FRIDAY);
                    RewardUtils::getChecker($player, $allowedDays, $day, self::FRIDAY, function (bool $result) use ($player): void {
                        if($result){
                            return;
                        }
                        // Receive reward
                        RewardModeUtils::sendFridayInventoryCustom($player);
                    });
                break;

                case 5: // Saturday
                    $allowedDays = ["Saturday"];
                    $day = strtolower(self::SATURDAY);
                    RewardUtils::getChecker($player, $allowedDays, $day, self::SATURDAY, function (bool $result) use ($player): void {
                        if($result){
                            return;
                        }
                        // Receive reward
                        RewardModeUtils::sendSaturdayInventoryCustom($player);
                    });
                break;

                case 6: // Sunday
                    $allowedDays = ["Sunday"];
                    $day = strtolower(self::SUNDAY);
                    RewardUtils::getChecker($player, $allowedDays, $day, self::SUNDAY, function (bool $result) use ($player): void {
                        if($result){
                            return;
                        }
                        // Receive reward
                        RewardModeUtils::sendSundayInventoryCustom($player);
                    });
                break;

                case 7: // close
                    PluginUtils::PlaySound($player, "random.pop2", 1, 4.1);
                break;
            }
        });
        $form->setTitle(Loader::getMessage($player, "RewardForm.Diary.title"));
        $form->setContent(Loader::getMessage($player, "RewardForm.Diary.content"));
        $form->addButton(Loader::getMessage($player, "RewardForm.Diary.button-monday"),1,"https://i.imgur.com/8xiDoTC.png");
        $form->addButton(Loader::getMessage($player, "RewardForm.Diary.button-tuesday"),1,"https://i.imgur.com/8xiDoTC.png");
        $form->addButton(Loader::getMessage($player, "RewardForm.Diary.button-wednesday"),1,"https://i.imgur.com/8xiDoTC.png");
        $form->addButton(Loader::getMessage($player, "RewardForm.Diary.button-thursday"),1,"https://i.imgur.com/8xiDoTC.png");
        $form->addButton(Loader::getMessage($player, "RewardForm.Diary.button-friday"),1,"https://i.imgur.com/8xiDoTC.png");
        $form->addButton(Loader::getMessage($player, "RewardForm.Diary.button-saturday"),1,"https://i.imgur.com/8xiDoTC.png");
        $form->addButton(Loader::getMessage($player, "RewardForm.Diary.button-sunday"),1,"https://i.imgur.com/8xiDoTC.png");
        $form->addButton(Loader::getMessage($player, "RewardForm.Diary.button-close"),0,"textures/ui/cancel");
        $player->sendForm($form);
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function getRewardMonthly(Player $player): void{
        $form = new SimpleForm(function(Player $player, $data){
            if(is_null($data)){
                return;
            }
            switch($data){
                case 0: // Reward
                    // Cooldown
                    CooldownUtils::hasCooldown($player, self::MONTHLY, function (bool $result) use ($player): void {
                        if ($result) {
                             CooldownUtils::getRemainingTime($player, self::MONTHLY, function (string $cooldown) use ($player): void {
                                 $player->sendMessage(Loader::Prefix(). str_replace(["{TIME}"], [$cooldown], Loader::getMessage($player, "Messages.you-have-cooldown")));
                             });
                        } else {
                            // Receive reward
                            RewardModeUtils::sendMonthlyInventoryCustom($player);
                        }
                    });
                break;

                case 1: // close
                    PluginUtils::PlaySound($player, "random.pop2", 1, 4.1);
                break;
            }
        });
        $form->setTitle(Loader::getMessage($player, "RewardForm.Monthly.title"));
        $form->setContent(Loader::getMessage($player, "RewardForm.Monthly.content"));
        $form->addButton(Loader::getMessage($player, "RewardForm.Monthly.button-reward"),1,"https://i.imgur.com/hXsKLCT.png");
        $form->addButton(Loader::getMessage($player, "RewardForm.Monthly.button-close"),0,"textures/ui/cancel");
        $player->sendForm($form);
    }
}