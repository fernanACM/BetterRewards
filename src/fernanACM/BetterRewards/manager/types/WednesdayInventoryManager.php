<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\BetterRewards\manager\types;

use pocketmine\player\Player;

use pocketmine\utils\Config;

use pocketmine\item\Item;
use pocketmine\inventory\Inventory;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\type\InvMenuTypeIds;

use fernanACM\BetterRewards\Loader;
use fernanACM\BetterRewards\manager\InventoryManager;

class WednesdayInventoryManager extends InventoryManager{

    /** @var array $menu */
    private static array $menu = [];

    /**
     * @return InvMenu
     */
    public static function getInvMenu(): InvMenu{
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
        $menu->setName("Wednesday inventory");
        $menu->getInventory()->setContents(self::getContents());
        return $menu;
    }

    /**
     * @param array $content
     * @return void
     */
    public static function setContents(array $content): void{
        self::$menu = $content;
    }

    public static function getContents(): array{
        $menu = [];
        foreach(self::$menu as $content => $item){
            $menu[$content] = $item;
        }
        return $menu;
    }

    /**
     * @param int $amount
     * @return array
     */
    public static function getRandomItems(int $amount): array{
        $menu = self::getContents();
        $items = [];
        for($i = 0; $i < $amount; $i++){
            $items[] = $menu[array_rand($menu)];
        }
        return $items;
    }

    /**
     * @param Player $player
     * @return void
     */
    public static function sendEditContent(Player $player): void{
        $menu = self::getInvMenu();
        $menu->setInventoryCloseListener(function(Player $player, Inventory $inventory): void{
            $content = [];
            foreach($inventory->getContents() as $index => $item){
                $content[$index] = $item;
            }
            self::setContents($content);
            // backup
            self::saveWednesdayInventory();
            $player->sendMessage(Loader::Prefix(). Loader::getMessage($player, "Messages.inventory-saved-successfully"));
        });
        $menu->send($player);
    }

    /**
     * @return void
     */
    public static function saveWednesdayInventory(): void{
        $backup = new Config(Loader::getInstance()->getDataFolder(). "backup/wednesdayInv.json");
        $menu = MondayInventoryManager::getContents();
        $place = [];
        foreach($menu as $content => $item){
            $place[$content]["slot"] = $content;
            $place[$content]["item"] = $item->jsonSerialize();
        }
        $backup->setAll($place);
        $backup->save();
    }

    /**
     * @return void
     */
    public static function loadWednesdayInventory(): void{
        $inv = new Config(Loader::getInstance()->getDataFolder(). "backup/wednesdayInv.json");
        $contents = [];
        foreach($inv->getAll() as $content){
            $item = Item::jsonDeserialize($content["item"]);
            $contents[$content["slot"]] = $item;
        }
        self::setContents($contents);
    }
}