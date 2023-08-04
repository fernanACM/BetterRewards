<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM
    
namespace fernanACM\BetterRewards\provider;

interface DatabaseProvider{

    /**
     * @return void
     */
    public function loadDatabase(): void;

    /**
     * @return void
     */
    public function unloadDatabase(): void;

    /**
     * @param string $playerName
     * @param string $id
     * @param integer $duration
     * @return void
     */
    public function addCooldown(string $playerName, string $id, int $duration): void;

    /**
     * @param string $playerName
     * @param string $id
     * @return void
     */
    public function removeCooldown(string $playerName, string $id): void;

    /**
     * @param string $playerName
     * @param string $id
     * @return boolean
     */
    public function hasCooldown(string $playerName, string $id): bool;

    /**
     * @param string $playerName
     * @param string $id
     * @return array|null
     */
    public function getCooldownData(string $playerName, string $id): ?array;
}