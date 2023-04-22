<?php

namespace fernanACM\BetterRewards\commands;

use pocketmine\player\Player;

use pocketmine\command\CommandSender;

use CortexPE\Commando\BaseCommand;

use fernanACM\BetterRewards\commands\subcommands\CountSubCommand;
use fernanACM\BetterRewards\commands\subcommands\EditSubCommand;
use fernanACM\BetterRewards\commands\subcommands\DiarySubCommand;
use fernanACM\BetterRewards\commands\subcommands\MonthlySubCommand;

use fernanACM\BetterRewards\forms\RewardForm;
use fernanACM\BetterRewards\utils\PluginUtils;
use fernanACM\BetterRewards\Loader;
use Vecnavium\FormsUI\SimpleForm;

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
        $this->registerSubCommand(new DiarySubCommand());
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
        $this->getRewardsForm($sender);
        PluginUtils::PlaySound($sender, "random.pop", 1, 2.5);
    }

    public function getRewardsForm(Player $player): void{
        $form = new SimpleForm(function(Player $player, $data){
            if($data === null){
                return true;
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
}