<?php
    
#      _       ____   __  __ 
#     / \     / ___| |  \/  |
#    / _ \   | |     | |\/| |
#   / ___ \  | |___  | |  | |
#  /_/   \_\  \____| |_|  |_|
# The creator of this plugin was fernanACM.
# https://github.com/fernanACM

namespace fernanACM\BetterRewards;

use pocketmine\Server;
use pocketmine\player\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
# Libs
use Vecnavium\FormsUI\FormsUI;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;
use muqsit\simplepackethandler\SimplePacketHandler;

use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\PacketHooker;

use DaPigGuy\libPiggyUpdateChecker\libPiggyUpdateChecker;
# My files
use fernanACM\BetterRewards\commands\RewardCommand;

use fernanACM\BetterRewards\manager\BackupManager;
use fernanACM\BetterRewards\provider\ProviderManager;

use fernanACM\BetterRewards\utils\PluginUtils;

class BetterRewards extends PluginBase{

    /** @var Config $config */
    public Config $config;

    /** @var Config $messages */
    public Config $messages;

    /** @var BetterRewards $instance */
    private static BetterRewards $instance;

    # CheckConfig
    private const CONFIG_VERSION = "2.0.0";
    private const LANGUAGE_VERSION = "2.0.0";

    # MultiLanguages
    private const LANGUAGES = [
        "eng", // English
        "spa", // Spanish
        "ger", // German
        "frc", // French
        "portg", // Portuguese
        "indo", // Indonesian
        "vie" // Vietnamese
    ];

    /**
     * @return void
     */
    public function onLoad(): void{
        self::$instance = $this;
        $this->loadFiles();
    }

    /**
     * @return void
     */
    public function onEnable(): void{
        $this->loadCheck();
        $this->loadVirions();
        $this->loadCommands();
        $this->getProvider()->loadProvider();
        BackupManager::loadInventoryAll();
    }

    /**
     * @return void
     */
    public function onDisable(): void{
        BackupManager::saveInventoryAll();
        $this->getProvider()->unloadProvider();
    }

    /**
     * @return void
     */
    private function loadFiles(): void{
        # Config files
        @mkdir($this->getDataFolder() . "languages");
        @mkdir($this->getDataFolder() . "backup");
        @mkdir($this->getDataFolder() . "database");
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml");
        # Languages
        foreach(self::LANGUAGES as $language){
            $this->saveResource("languages/" . $language . ".yml");
        }
        $this->messages = new Config($this->getDataFolder() . "languages/" . $this->config->get("language") . ".yml");
    }

    /**
     * @return void
     */
    private function loadCheck(): void{
        # CONFIG
        if((!$this->config->exists("config-version")) || ($this->config->get("config-version") != self::CONFIG_VERSION)){
            rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "config_old.yml");
            $this->saveResource("config.yml");
            $this->getLogger()->critical("Your configuration file is outdated.");
            $this->getLogger()->notice("Your old configuration has been saved as config_old.yml and a new configuration file has been generated. Please update accordingly.");
        }
        # LANGUAGES
        $data = new Config($this->getDataFolder() . "languages/" . $this->config->get("language") . ".yml");
        if((!$data->exists("language-version")) || ($data->get("language-version") != self::LANGUAGE_VERSION)){
            rename($this->getDataFolder() . "languages/" . $this->config->get("language") . ".yml", $this->getDataFolder() . "languages/" . $this->config->get("language") . "_old.yml");
            foreach(self::LANGUAGES as $language){
                $this->saveResource("languages/" . $language . ".yml");
            }
            $this->getLogger()->critical("Your ".$this->config->get("language").".yml file is outdated.");
            $this->getLogger()->notice("Your old ".$this->config->get("language").".yml has been saved as ".$this->config->get("language")."_old.yml and a new ".$this->config->get("language").".yml file has been generated. Please update accordingly.");
        }
    }

    /**
     * @return void
     */
    private function loadCommands(): void{
        Server::getInstance()->getCommandMap()->register("betterrewards", new RewardCommand());
    }

    /**
     * @return void
     */
    private function loadVirions(): void{
        foreach([
            "FormsUI" => FormsUI::class,
            "InvMenu" => InvMenu::class,
            "SimplePacketHandler" => SimplePacketHandler::class,
            "Commando" => BaseCommand::class,
            "libPiggyUpdateChecker" => libPiggyUpdateChecker::class
            ] as $virion => $class
        ){
            if(!class_exists($class)){
                $this->getLogger()->error($virion . " virion not found. Please download BetterRewards from Poggit-CI or use DEVirion (not recommended).");
                $this->getServer()->getPluginManager()->disablePlugin($this);
                return;
            }
        }

        if(!PacketHooker::isRegistered()){
            PacketHooker::register($this);
        }

        if(!InvMenuHandler::isRegistered()){
            InvMenuHandler::register($this);
        }
        # Update
        libPiggyUpdateChecker::init($this);
    }

    /**
     * @return BetterRewards
     */
    public static function getInstance(): BetterRewards{
        return self::$instance;
    }

    /**
     * @return ProviderManager
     */
    public function getProvider(): ProviderManager{
        return ProviderManager::getInstance();
    }

    /**
     * @param Player $player
     * @param string $key
     * @return string
     */
    public static function getMessage(Player $player, string $key): string{
        $messageArray = self::$instance->messages->getNested($key, []);
        if(!is_array($messageArray)){
            $messageArray = [$messageArray];
        }
        $message = implode("\n", $messageArray);
        return PluginUtils::codeUtil($player, $message);
    }

    /**
     * @return string
     */
    public static function Prefix(): string{
        return TextFormat::colorize(self::$instance->config->get("Prefix"));
    }
}
