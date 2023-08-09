<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM
    
namespace fernanACM\BetterRewards\provider;

use fernanACM\BetterRewards\BetterRewards;
use poggit\libasynql\DataConnector;
use poggit\libasynql\libasynql;

abstract class DatabaseProvider{

    const INIT_QUERY = "betterrewards.init";
    const ADD_COOLDOWN_QUERY = "betterrewards.addcooldown";
    const REMOVE_COOLDOWN_QUERY = "betterrewards.removecooldown";
    const GET_COOLDOWN_QUERY = "betterrewards.getcooldown";

    protected DataConnector $database;

    /**
     * @return void
     */
    public function loadDatabase(): void {
        $betterRewards = BetterRewards::getInstance();
        $config = $betterRewards->config;
        $this->database = libasynql::create($betterRewards, $config->get("database"), [
            "sqlite" => "sqlite.sql",
            "mysql" => "mysql.sql"
        ]);
        $this->database->executeGeneric(self::INIT_QUERY);
    }

    /**
     * @return DataConnector
     */
    public function getDatabase(): DataConnector {
        return $this->database;
    }

    /**
     * @return void
     */
    public function unloadDatabase(): void{
        if(isset($this->database))
            $this->database->close();
    }

    /**
     * @param string $playerName
     * @param string $id
     * @param integer $expirationTime
     * @return void
     */
    public function addCooldown(string $playerName, string $id, int $expirationTime): void {
        $this->database->executeInsert(self::ADD_COOLDOWN_QUERY, [
            "player" => $playerName,
            "cooldown_id" => $id,
            "expiration" => $expirationTime
        ]);
    }

    /**
     * @param string $playerName
     * @param string $id
     * @return void
     */
    public function removeCooldown(string $playerName, string $id): void{
        $this->database->executeChange(self::REMOVE_COOLDOWN_QUERY, [
            "player" => $playerName,
            "cooldown_id" => $id
        ]);
    }

    /**
     * @param string   $playerName
     * @param string   $id
     * @param callable $onSelect
     * @return void
     */
    public function getCooldownData(string $playerName, string $id, callable $onSelect): void{
        $this->database->executeSelect(self::GET_COOLDOWN_QUERY, [
            "player" => $playerName,
            "cooldown_id" => $id
        ], $onSelect);
    }
}