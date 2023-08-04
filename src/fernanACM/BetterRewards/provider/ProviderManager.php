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
        $databaseType = $config->getNested("Database.type");
        switch(strtolower($databaseType)){
            case "sqlite":
            case "sqlite3":
            case "sql":
                self::$provider = SQLProvider::getInstance();
            break;

            case "mysql":
            case "mysqli":
                self::$provider = MySQLProvider::getInstance();
            break;

            default:
                self::$provider = SQLProvider::getInstance();
            break;
        }
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
     * @param string $playerName
     * @param string $id
     * @return boolean
     */
    public function hasCooldown(string $playerName, string $id): bool{
        return self::$provider->hasCooldown($playerName, $id);
    }

    /**
     * @param string $playerName
     * @param string $id
     * @return array|null
     */
    public function getCooldownData(string $playerName, string $id): ?array{
        return self::$provider->getCooldownData($playerName, $id);
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