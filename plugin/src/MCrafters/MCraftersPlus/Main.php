<?php

/*
 * __  __  ____            __ _                        
 *|  \/  |/ ___|_ __ __ _ / _| |_ ___ _ __ ___     _   
 *| |\/| | |   | '__/ _` | |_| __/ _ \ '__/ __|  _| |_ 
 *| |  | | |___| | | (_| |  _| ||  __/ |  \__ \ |_   _|
 *|_|  |_|\____|_|  \__,_|_|  \__\___|_|  |___/   |_|  
 *
*/

namespace MCrafters\MCraftersPlus;

use pocketmine\plugin\PluginBase;
use MCrafters\MCraftersPlus\task\QueryHandler;

class Main extends PluginBase{
  
  protected $plugins = [
    "MTeamPvP",
    "WarnPlayer",
    "ItemChest",
    "ServerManager",
    "opmanager",
    "MSpleef",
    "TradePro",
    "MHelpModifer",
    "ReportHacker",
    "MoneyTag",
    "FlagSpiral",
    "FlyCommand",
    "JoinLeaveMessages",
    "UserGeo"
    ];
  
  public function onEnable(){
    $this->getLogger()->info("Enabling MCraftersPlus...");
    $this->getServer()->getScheduler()->scheduleRepeatingTask(new QueryHandler($this), (30 * 60 *20));
  }
  
  public function onDisable(){
    $this->getLogger()->info("Disabling MCraftersPlus...");
  }
  
  public function getInput($default = ""){
    $input = trim(fgets(STDIN));
    return $input === "" ? $default : $input;
  }
  
}
