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
use Vecnavium\FormsUI\SimpleForm;

use fernanACM\BetterRewards\manager\types\FridayInventoryManager;
use fernanACM\BetterRewards\manager\types\MondayInventoryManager;
use fernanACM\BetterRewards\manager\types\MonthlyInventoryManager;
use fernanACM\BetterRewards\manager\types\SaturdayInventoryManager;
use fernanACM\BetterRewards\manager\types\SundayInventoryManager;
use fernanACM\BetterRewards\manager\types\ThursdayInventoryManager;
use fernanACM\BetterRewards\manager\types\TuesdayInventoryManager;
use fernanACM\BetterRewards\manager\types\WednesdayInventoryManager;

use fernanACM\BetterRewards\BetterRewards as Loader;
use fernanACM\BetterRewards\utils\PluginUtils;

class EditSubCommand extends BaseSubCommand{

    public function __construct(){
        parent::__construct("edit", "Edit daily and monthly reward inventories by fernanACM", ["editar"]);
        $this->setPermission("betterrewards.edit.acm");
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

        if(!$sender->hasPermission("betterrewards.edit.acm")){
            $sender->sendMessage(Loader::Prefix(). Loader::getMessage($sender, "Messages.no-permission"));
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            return;
        }

        if(Loader::getInstance()->getInstance()->config->getNested("Settings.inventory.custom-inventory")){
            $this->editInventory($sender);
            PluginUtils::PlaySound($sender, "random.fizz", 1, 1);
        }else{
            $sender->sendMessage(Loader::Prefix(). Loader::getMessage($sender, "Messages.custom-inventory-not-activated"));
            PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
        }
    }

    /**
     * @param Player $player
     * @return void
     */
    public function editInventory(Player $player): void{
        $form = new SimpleForm(function(Player $player, $data){
            if($data === null){
                PluginUtils::PlaySound($player, "random.pop", 1, 3.2);
                return true;
            }
            switch($data){
                case 0:
                    MondayInventoryManager::sendEditContent($player);
                    PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
                break;

                case 1:
                    TuesdayInventoryManager::sendEditContent($player);
                    PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
                break;

                case 2:
                    WednesdayInventoryManager::sendEditContent($player);
                    PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
                break;

                case 3:
                    ThursdayInventoryManager::sendEditContent($player);
                    PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
                break;

                case 4:
                    FridayInventoryManager::sendEditContent($player);
                    PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
                break;

                case 5:
                    SaturdayInventoryManager::sendEditContent($player);
                    PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
                break;

                case 6:
                    SundayInventoryManager::sendEditContent($player);
                    PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
                break;

                case 7:
                    MonthlyInventoryManager::sendEditContent($player);
                    PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
                break;

                case 8:
                    PluginUtils::PlaySound($player, "random.pop", 1, 3.2);
                break;
            }
        });
        $form->setTitle("Edit inventory (BetterRewards)");
        $form->setContent("§eSelect inventory to edit:");
        $form->addButton("Monday inventory");
        $form->addButton("Tuesday inventory");
        $form->addButton("Wednesday inventory");
        $form->addButton("Thursday inventory");
        $form->addButton("Friday inventory");
        $form->addButton("Saturday inventory");
        $form->addButton("Sunday inventory");
        $form->addButton("Monthly inventory");
        $form->addButton("close menu",0,"textures/ui/cancel");
        $player->sendForm($form);
    }
}