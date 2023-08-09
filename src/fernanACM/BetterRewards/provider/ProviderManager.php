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

class ProviderManager{

    /** @var DatabaseProvider|null */
    private static ?DatabaseProvider $provider = null;

    /** @var ProviderManager|null $instance */
    private static ?ProviderManager $instance = null;

    private function __construct(){
    }

    /**
     * @return void
     */
    public function loadProvider(): void{
        $config = BetterRewards::getInstance()->config;
        $databaseType = $config->getNested("database.type");
        self::$provider = match (strtolower($databaseType)) {
            "mysql", "mysqli" => MySQLProvider::getInstance(),
            default => SQLProvider::getInstance()
        };
        if(!is_null(self::$provider)){
            self::$provider->loadDatabase();
        }
    }

    /**
     * @return void
     */
    public function unloadProvider(): void{
        self::$provider->unloadDatabase();
    }

    /**
     * @param string $playerName
     * @param string $id
     * @param integer $expirationTime
     * @return void
     */
    public function addCooldown(string $playerName, string $id, int $expirationTime): void{
        self::$provider->addCooldown($playerName, $id, $expirationTime);
    }

    /**
     * @param string $playerName
     * @param string $id
     * @return void
     */
    public function removeCooldown(string $playerName, string $id): void{
        self::$provider->removeCooldown($playerName, $id);
    }

    /**
     * @param string   $playerName
     * @param string   $id
     * @param callable $callback
     * @return void
     */
    public function getCooldownData(string $playerName, string $id, callable $callback): void{
        self::$provider->getCooldownData($playerName, $id, $callback);
    }

    /**
     * @return DatabaseProvider|null
     */
    public function getProvider(): ?DatabaseProvider{
        return self::$provider;
    }

    /**
     * @return self
     */
    public static function getInstance(): self{
        if(is_null(self::$instance)) self::$instance = new self();
        return self::$instance;
    }
}