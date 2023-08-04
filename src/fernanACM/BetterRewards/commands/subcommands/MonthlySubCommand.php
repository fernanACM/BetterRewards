<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\BetterRewards\commands\subcommands;

use pocketmine\player\Player;

use pocketmine\command\CommandSender;

use CortexPE\Commando\BaseSubCommand;

use fernanACM\BetterRewards\BetterRewards as Loader;
use fernanACM\BetterRewards\forms\RewardForm;
use fernanACM\BetterRewards\utils\PluginUtils;

class MonthlySubCommand extends BaseSubCommand{

    public function __construct(){
        parent::__construct("monthly", "The best monthly rewards by fernanACM", ["mly"]);
        $this->setPermission("betterrewards.monthly.acm");
    }

    /**
     * @return void
     */
    protected function prepare(): void{    
    }

    /**
     * @param CommandSender $sender
     * @param string $aliasUsed
     * @param array $args
     * @return void
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void{
        if(!$sender instanceof Player){
            $sender->sendMessage("Use this command in-game");
            return;
        }

        if(!$sender->hasPermission("betterrewards.monthly.acm")){
            $sender->sendMessage(Loader::Prefix(). Loader::getMessage($sender, "Messages.no-permission"));
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            return;
        }
        RewardForm::getRewardMonthly($sender);
        PluginUtils::PlaySound($sender, "random.pop", 1, 2.5);
    }
}