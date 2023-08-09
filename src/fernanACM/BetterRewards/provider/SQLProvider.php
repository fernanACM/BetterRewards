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

class SQLProvider extends DatabaseProvider{

    /** @var SQLProvider|null $instance */
    private static ?SQLProvider $instance = null;

    private function __construct(){
    }
    
    /**
     * @return self
     */
    public static function getInstance(): self{
        if(is_null(self::$instance))self::$instance = new self();
        return self::$instance;
    }
}