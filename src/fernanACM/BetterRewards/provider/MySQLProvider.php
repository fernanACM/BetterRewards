<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM
    
namespace fernanACM\BetterRewards\provider;

use mysqli;

use fernanACM\BetterRewards\BetterRewards;

class MySQLProvider implements DatabaseProvider{

    /** @var MySQLProvider|null $instance */
    private static ?MySQLProvider $instance = null;

    /** @var mysqli|null $database */
    private ?mysqli $database;

    private function __construct(){
    }
    
    /**
     * @return void
     */
    public function loadDatabase(): void{
        $config = BetterRewards::getInstance()->config;
        $dbHost = $config->getNested("Database.mysql.host", "localhost");
        $dbUsername = $config->getNested("Database.mysql.username", "your_username");
        $dbPassword = $config->getNested("Database.mysql.password", "your_password");
        $dbName = $config->getNested("Database.mysql.database-name", "your_database");
        $this->database = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

        if($this->database->connect_errno){
            BetterRewards::getInstance()->getLogger()->error('Error connecting to the database: ' . $this->database->connect_error);
        }
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
        $query = "CREATE TABLE IF NOT EXISTS cooldowns (player VARCHAR(255), cooldown_id VARCHAR(255), expiration INT)";
        $this->database->query($query);
    }

    /**
     * @param string $playerName
     * @param string $id
     * @param integer $expirationTime
     * @return void
     */
    public function addCooldown(string $playerName, string $id, int $expirationTime): void{
        $stmt = $this->database->prepare("INSERT INTO cooldowns (player, cooldown_id, expiration) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $playerName, $id, $expirationTime);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * @param string $playerName
     * @param string $id
     * @return void
     */
    public function removeCooldown(string $playerName, string $id): void{
        $stmt = $this->database->prepare("DELETE FROM cooldowns WHERE player = ? AND cooldown_id = ?");
        $stmt->bind_param("ss", $playerName, $id);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * @param string $playerName
     * @param string $id
     * @return boolean
     */
    public function hasCooldown(string $playerName, string $id): bool{
        $stmt = $this->database->prepare("SELECT expiration FROM cooldowns WHERE player = ? AND cooldown_id = ?");
        $stmt->bind_param("ss", $playerName, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data !== null;
    }

    /**
     * @param string $playerName
     * @param string $id
     * @return array|null
     */
    public function getCooldownData(string $playerName, string $id): ?array{
        $stmt = $this->database->prepare("SELECT * FROM cooldowns WHERE player = ? AND cooldown_id = ?");
        $stmt->bind_param("ss", $playerName, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data !== null ? $data : null;
    }

    /**
     * @return MySQLProvider|null
     */
    public function getDatabase(): ?MySQLProvider{
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