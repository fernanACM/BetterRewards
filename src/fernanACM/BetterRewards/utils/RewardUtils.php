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

use pocketmine\console\ConsoleCommandSender;

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
}