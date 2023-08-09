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

class MySQLProvider extends DatabaseProvider{

    /** @var MySQLProvider|null $instance */
    private static ?MySQLProvider $instance = null;

    /**
     * @return self
     */
    public static function getInstance(): self{
        if(is_null(self::$instance))self::$instance = new self();
        return self::$instance;
    }
}