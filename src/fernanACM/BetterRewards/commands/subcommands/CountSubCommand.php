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
use CortexPE\Commando\args\RawStringArgument;

use fernanACM\BetterRewards\manager\types\FridayInventoryManager;
use fernanACM\BetterRewards\manager\types\MondayInventoryManager;
use fernanACM\BetterRewards\manager\types\MonthlyInventoryManager;
use fernanACM\BetterRewards\manager\types\SaturdayInventoryManager;
use fernanACM\BetterRewards\manager\types\SundayInventoryManager;
use fernanACM\BetterRewards\manager\types\ThursdayInventoryManager;
use fernanACM\BetterRewards\manager\types\TuesdayInventoryManager;
use fernanACM\BetterRewards\manager\types\WednesdayInventoryManager;

use fernanACM\BetterRewards\Loader;
use fernanACM\BetterRewards\utils\PluginUtils;

class CountSubCommand extends BaseSubCommand{

    private const MONDAY = "monday";
    private const TUESDAY = "tuesday";
    private const WEDNESDAY = "wednesday";
    private const THURSDAY = "thursday";
    private const FRIDAY = "friday";
    private const SATURDAY = "saturday";
    private const SUNDAY = "sunday";
    private const MONTHLY = "monthly";

    public function __construct(){
        parent::__construct("count", "Count daily and monthly reward inventories by fernanACM", ["contar"]);
        $this->setPermission("betterrewards.edit.acm");
    }

    /**
     * @return void
     */
    protected function prepare(): void{
        $this->registerArgument(0, new RawStringArgument("type", true));    
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

        if(!isset($args["type"])){
            if(Loader::getInstance()->getInstance()->config->getNested("Settings.inventory.custom-inventory")){
                $sender->sendMessage(Loader::Prefix(). "§cUse: /modos count <type>");
                PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            }else{
                $sender->sendMessage(Loader::Prefix(). Loader::getMessage($sender, "Messages.custom-inventory-not-activated"));
                PluginUtils::PlaySound($sender, "mob.villager.no", 1, 1);
            }
        }
        
        if(!$this->isAvailable($args["type"])){
            $sender->sendMessage(Loader::Prefix(). "§cThe mode§b ".$args[1]." §cit's not valid.");
            $sender->sendMessage("§l§9List of valid modes:");
            foreach(self::getModos() as $modes){
                $sender->sendMessage(" - §a" . $modes);
                PluginUtils::PlaySound($sender, "random.pop2", 1, 1.5);
            }
            return;
        }
        $this->getInventoryCount($sender, $args["type"]);
    }

    /**
     * @param Player $player
     * @param string $type
     * @return void
     */
    public function getInventoryCount(Player $player, string $type): void{
        switch($type){
            case "monday":
                $count = MondayInventoryManager::getNumContents();
                $player->sendMessage(Loader::Prefix(). "§a$type: §b$count §aitems");
                PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
            break;

            case "tuesday":
                $count = TuesdayInventoryManager::getNumContents();
                $player->sendMessage(Loader::Prefix(). "§a$type: §b$count §aitems");
                PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
            break;

            case "wednesday":
                $count = WednesdayInventoryManager::getNumContents();
                $player->sendMessage(Loader::Prefix(). "§a$type: §b$count §aitems");
                PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
            break;

            case "thursday":
                $count = ThursdayInventoryManager::getNumContents();
                $player->sendMessage(Loader::Prefix(). "§a$type: §b$count §aitems");
                PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
            break;

            case "friday":
                $count = FridayInventoryManager::getNumContents();
                $player->sendMessage(Loader::Prefix(). "§a$type: §b$count §aitems");
                PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
            break;

            case "saturday":
                $count = SaturdayInventoryManager::getNumContents();
                $player->sendMessage(Loader::Prefix(). "§a$type: §b$count §aitems");
                PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
            break;

            case "sunday":
                $count = SundayInventoryManager::getNumContents();
                $player->sendMessage(Loader::Prefix(). "§a$type: §b$count §aitems");
                PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
            break;

            case "monthly":
                $count = MonthlyInventoryManager::getNumContents();
                $player->sendMessage(Loader::Prefix(). "§a$type: §b$count §aitems");
                PluginUtils::PlaySound($player, "random.pop2", 1, 3.2);
            break;
        }
    }

    /**
     * @return array
     */
    public static function getModos(): array{
        return [self::MONDAY, self::TUESDAY, self::WEDNESDAY, 
        self::THURSDAY, self::FRIDAY, self::SATURDAY, self::SUNDAY, self::MONTHLY];
    }

    /**
     * @param string $mode
     * @return bool
     */
    public static function isAvailable(string $mode): bool{
		$modes = self::getModos();
		if(in_array($mode, $modes)){
			return true;
		}
		return false;
	}
}