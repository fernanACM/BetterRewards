<?php

namespace fernanACM\BetterRewards\commands;

use pocketmine\player\Player;

use pocketmine\command\CommandSender;

use CortexPE\Commando\BaseCommand;

use fernanACM\BetterRewards\commands\subcommands\CountSubCommand;
use fernanACM\BetterRewards\commands\subcommands\EditSubCommand;
use fernanACM\BetterRewards\commands\subcommands\MonthlySubCommand;

use fernanACM\BetterRewards\forms\RewardForm;
use fernanACM\BetterRewards\utils\PluginUtils;
use fernanACM\BetterRewards\Loader;

class RewardCommand extends BaseCommand{

    public function __construct(){
        parent::__construct(Loader::getInstance(), "betterrewards", "The best daily rewards by fernanACM", ["betterewards", "btrewards", "reward"]);
        $this->setPermission("betterrewards.cmd.acm");
    }

    /**
     * @return void
     */
    protected function prepare(): void{
        $this->registerSubCommand(new EditSubCommand());
        $this->registerSubCommand(new MonthlySubCommand());
        $this->registerSubCommand(new CountSubCommand());
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

        if(!$sender->hasPermission("betterrewards.cmd.acm")){
            $sender->sendMessage(Loader::Prefix(). Loader::getMessage($sender, "Messages.no-permission"));
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            return;
        }
        RewardForm::getRewardDiary($sender);
        PluginUtils::PlaySound($sender, "random.pop", 1, 2.5);
    }
}