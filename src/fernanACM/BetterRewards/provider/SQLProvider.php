<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM
    
namespace fernanACM\BetterRewards\provider;

use SQLite3;

use fernanACM\BetterRewards\BetterRewards;

class SQLProvider implements DatabaseProvider{

    /** @var SQLProvider|null $instance */
    private static ?SQLProvider $instance = null;

    /** @var SQLite3|null $database */
    private ?SQLite3 $database;

    private function __construct(){
    }
    
    /**
     * @return void
     */
    public function loadDatabase(): void{
        BetterRewards::getInstance()->saveResource("BetterRewards.db");
        $this->database = new SQLite3(BetterRewards::getInstance()->getDataFolder(). "database/BetterRewards.db");
        $this->createTable();
    }

    /**
     * @return void
     */
    public function unloadDatabase(): void{
        if(isset($this->database))
        $this->database->close();
    }

    /**
     * @return void
     */
    private function createTable(): void{
        $this->database->exec("CREATE TABLE IF NOT EXISTS cooldowns (player TEXT, cooldown_id TEXT, expiration INT)");
    }

    /**
     * @param string $playerName
     * @param string $id
     * @param integer $expirationTime
     * @return void
     */
    public function addCooldown(string $playerName, string $id, int $expirationTime): void{
        $stmt = $this->database->prepare("INSERT OR REPLACE INTO cooldowns (player, cooldown_id, expiration) VALUES (:player, :cooldown_id, :expiration)");
        $stmt->bindValue(":player", $playerName);
        $stmt->bindValue(":cooldown_id", $id);
        $stmt->bindValue(":expiration", $expirationTime);
        $stmt->execute();
    }

    /**
     * @param string $playerName
     * @param string $id
     * @return void
     */
    public function removeCooldown(string $playerName, string $id): void{
        $stmt = $this->database->prepare("DELETE FROM cooldowns WHERE player = :player AND cooldown_id = :cooldown_id");
        $stmt->bindValue(":player", $playerName);
        $stmt->bindValue(":cooldown_id", $id);
        $stmt->execute();
    }

    /**
     * @param string $playerName
     * @param string $id
     * @return boolean
     */
    public function hasCooldown(string $playerName, string $id): bool{
        $database = SQLProvider::getInstance()->getDatabase();
        $stmt = $database->prepare("SELECT expiration FROM cooldowns WHERE player = :player AND cooldown_id = :cooldown_id");
        $stmt->bindValue(":player", $playerName);
        $stmt->bindValue(":cooldown_id", $id);
        $result = $stmt->execute();
        if($result === false){
            return false;
        }
        $data = $result->fetchArray(SQLITE3_ASSOC);
        return $data !== false;
    }

    /**
     * @param string $playerName
     * @param string $id
     * @return array|null
     */
    public function getCooldownData(string $playerName, string $id): ?array{
        $stmt = $this->database->prepare("SELECT * FROM cooldowns WHERE player = :player AND cooldown_id = :cooldown_id");
        $stmt->bindValue(":player", $playerName);
        $stmt->bindValue(":cooldown_id", $id);
        $result = $stmt->execute();
        if($result === false){
            return null;
        }
        $data = $result->fetchArray(SQLITE3_ASSOC);
        if($data === false){
            return null;
        }
        return $data;
    }

    /**
     * @return SQLite3|null
     */
    public function getDatabase(): ?SQLite3{
        return $this->database;
    }

    /**
     * @return self
     */
    public static function getInstance(): self{
        if(is_null(self::$instance))self::$instance = new self();
        return self::$instance;
    }
}