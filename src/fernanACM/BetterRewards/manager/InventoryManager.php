<?php

namespace fernanACM\BetterRewards\manager;

use pocketmine\player\Player;

use muqsit\invmenu\InvMenu;

abstract class InventoryManager{

    /**
     * @return InvMenu
     */
    abstract public static function getInvMenu(): InvMenu;

    /**
     * @param array $content
     * @return void
     */
    abstract public static function setContents(array $content): void;

    /**
     * @return array
     */
    abstract public static function getContents(): array;

    /**
     * @param int $amount
     * @return array
     */
    abstract public static function getRandomItems(int $amount): array;

    /**
     * @param Player $player
     * @return void
     */
    abstract public static function sendEditContent(Player $player): void;
}